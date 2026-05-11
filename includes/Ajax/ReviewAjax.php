<?php
namespace JR_Addons\Ajax;

if ( ! defined( 'ABSPATH' ) ) exit;

class ReviewAjax {

    public static function init() {
        // Review submit
        add_action( 'wp_ajax_jr_submit_review',        [ __CLASS__, 'submit_review' ] );
        add_action( 'wp_ajax_nopriv_jr_submit_review', [ __CLASS__, 'submit_review' ] );

        // ✅ Reply submit (only logged-in users)
        add_action( 'wp_ajax_jr_submit_reply', [ __CLASS__, 'submit_reply' ] );
    }

    /**
     * Submit Review
     */
    public static function submit_review() {
        check_ajax_referer( 'jr_submit_review', 'nonce' );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $content    = isset( $_POST['review_content'] ) ? wp_kses_post( wp_unslash( $_POST['review_content'] ) ) : '';
        $rating     = isset( $_POST['rating'] ) ? absint( $_POST['rating'] ) : 0;
        $recommend  = isset( $_POST['recommend'] ) ? sanitize_text_field( $_POST['recommend'] ) : 'yes';

        if ( ! $product_id ) {
            wp_send_json_error( [ 'message' => 'Invalid product.' ] );
        }
        if ( empty( $content ) ) {
            wp_send_json_error( [ 'message' => 'Please write a review.' ] );
        }
        if ( $rating < 1 || $rating > 5 ) {
            wp_send_json_error( [ 'message' => 'Please select a rating.' ] );
        }

        $user = wp_get_current_user();
        if ( $user->ID ) {
            $name  = $user->display_name;
            $email = $user->user_email;
        } else {
            $name  = isset( $_POST['reviewer_name'] ) ? sanitize_text_field( wp_unslash( $_POST['reviewer_name'] ) ) : '';
            $email = isset( $_POST['reviewer_email'] ) ? sanitize_email( wp_unslash( $_POST['reviewer_email'] ) ) : '';

            if ( empty( $name ) || empty( $email ) || ! is_email( $email ) ) {
                wp_send_json_error( [ 'message' => 'Please provide valid name and email.' ] );
            }
        }

        // ============================================
        // Moderation check
        // ============================================
        $approved = self::jr_check_review_approval( $email, $user->ID );

        // ============================================
        // Insert Comment
        // ============================================
        $comment_data = [
            'comment_post_ID'      => $product_id,
            'comment_author'       => $name,
            'comment_author_email' => $email,
            'comment_author_IP'    => self::jr_get_ip(),
            'comment_agent'        => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 254 ) : '',
            'comment_content'      => $content,
            'comment_type'         => 'review',
            'comment_approved'     => $approved,
            'user_id'              => $user->ID,
            'comment_date'         => current_time( 'mysql' ),
            'comment_date_gmt'     => current_time( 'mysql', 1 ),
        ];

        $comment_id = wp_insert_comment( $comment_data );

        if ( ! $comment_id ) {
            wp_send_json_error( [ 'message' => 'Failed to submit. Try again.' ] );
        }

        add_comment_meta( $comment_id, 'rating', $rating );
        add_comment_meta( $comment_id, 'jr_recommend', $recommend );

        // Verified buyer check
        if ( $user->ID && function_exists( 'wc_customer_bought_product' ) && wc_customer_bought_product( $email, $user->ID, $product_id ) ) {
            add_comment_meta( $comment_id, 'verified', 1 );
        } else {
            add_comment_meta( $comment_id, 'verified', 0 );
        }

        // Clear WC transients
        if ( class_exists( 'WC_Comments' ) ) {
            \WC_Comments::clear_transients( $product_id );
        }

        // Notification email
        if ( $approved === 0 ) {
            wp_notify_moderator( $comment_id );
        } else {
            wp_notify_postauthor( $comment_id );
        }

        wp_send_json_success( [
            'message'  => $approved 
                ? 'Thank you! Your review has been published.' 
                : 'Thank you! Your review is pending approval.',
            'approved' => $approved,
        ] );
    }

    /**
     * ✅ NEW: Submit Reply to a Review
     */
    public static function submit_reply() {
        check_ajax_referer( 'jr_submit_reply', 'nonce' );

        if ( ! is_user_logged_in() ) {
            wp_send_json_error( [ 'message' => 'You must be logged in to reply.' ] );
        }

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $parent_id  = isset( $_POST['parent_id'] ) ? absint( $_POST['parent_id'] ) : 0;
        $content    = isset( $_POST['reply_content'] ) ? wp_kses_post( wp_unslash( $_POST['reply_content'] ) ) : '';

        if ( ! $product_id || ! $parent_id ) {
            wp_send_json_error( [ 'message' => 'Invalid request.' ] );
        }

        if ( empty( $content ) ) {
            wp_send_json_error( [ 'message' => 'Please write a reply.' ] );
        }

        // Verify parent comment
        $parent_comment = get_comment( $parent_id );
        if ( ! $parent_comment || (int) $parent_comment->comment_post_ID !== $product_id ) {
            wp_send_json_error( [ 'message' => 'Parent review not found.' ] );
        }

        $user = wp_get_current_user();

        // Admin replies auto-approve, others use moderation rules
        $is_admin = current_user_can( 'manage_options' );
        $approved = $is_admin ? 1 : ( '1' === get_option( 'comment_moderation' ) ? 0 : 1 );

        $comment_id = wp_insert_comment( [
            'comment_post_ID'      => $product_id,
            'comment_parent'       => $parent_id,
            'comment_author'       => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_author_IP'    => self::jr_get_ip(),
            'comment_agent'        => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 254 ) : '',
            'comment_content'      => $content,
            'comment_type'         => 'review',
            'comment_approved'     => $approved,
            'user_id'              => $user->ID,
            'comment_date'         => current_time( 'mysql' ),
            'comment_date_gmt'     => current_time( 'mysql', 1 ),
        ] );

        if ( ! $comment_id ) {
            wp_send_json_error( [ 'message' => 'Failed to post reply.' ] );
        }

        // Mark as reply
        add_comment_meta( $comment_id, 'jr_is_reply', 1 );

        // Notification
        if ( $approved ) {
            wp_notify_postauthor( $comment_id );
        } else {
            wp_notify_moderator( $comment_id );
        }

        wp_send_json_success( [
            'message'  => $approved ? 'Reply posted successfully!' : 'Reply submitted, pending approval.',
            'approved' => $approved,
        ] );
    }

    /**
     * Check review approval
     */
    private static function jr_check_review_approval( $email, $user_id = 0 ) {
        
        // 1️⃣ WooCommerce verified owners check
        if ( 'yes' === get_option( 'woocommerce_review_rating_verification_required' ) ) {
            // Optional logic here
        }

        // 2️⃣ Manual moderation
        if ( '1' === get_option( 'comment_moderation' ) ) {
            return 0;
        }

        // 3️⃣ Previously approved required
        if ( '1' === get_option( 'comment_previously_approved' ) ) {
            global $wpdb;
            $previous_approved = $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->comments} 
                WHERE comment_author_email = %s 
                AND comment_approved = '1' 
                LIMIT 1",
                $email
            ) );

            if ( ! $previous_approved ) {
                return 0;
            }
        }

        // 4️⃣ Spam check
        $disallowed = wp_check_comment_disallowed_list( '', '', $email, '', '', '' );
        if ( $disallowed ) {
            return 'spam';
        }

        return 1;
    }

    /**
     * Get user IP safely
     */
    private static function jr_get_ip() {
        $ip = '';
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] )[0];
        } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return filter_var( trim( $ip ), FILTER_VALIDATE_IP ) ?: '';
    }
}