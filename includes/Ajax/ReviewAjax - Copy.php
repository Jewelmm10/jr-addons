<?php

namespace JR_Addons\Ajax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ReviewAjax {

	/**
	 * Init AJAX hooks
	 */
	public static function init() {

		add_action( 'wp_ajax_jr_submit_review',[ __CLASS__, 'submit_review' ] );
		add_action( 'wp_ajax_nopriv_jr_submit_review', [ __CLASS__, 'submit_review' ] );
	}

	/**
	 * Submit Review
	 */
	public static function submit_review() {

		error_log( 'JR submit_review triggered' );

		// Verify nonce
		check_ajax_referer( 'jr_submit_review', 'nonce' );

		$product_id = isset( $_POST['product_id'] )
			? absint( $_POST['product_id'] )
			: 0;

		$content = isset( $_POST['review_content'] )
			? wp_kses_post( wp_unslash( $_POST['review_content'] ) )
			: '';

		$rating = isset( $_POST['rating'] )
			? absint( $_POST['rating'] )
			: 0;

		$recommend = isset( $_POST['recommend'] )
			? sanitize_text_field( wp_unslash( $_POST['recommend'] ) )
			: 'yes';

		// Validate product
		if ( ! $product_id || ! get_post( $product_id ) ) {

			wp_send_json_error(
				[
					'message' => __( 'Invalid product.', 'jr-addons' ),
				]
			);
		}

		// Validate content
		if ( empty( $content ) ) {

			wp_send_json_error(
				[
					'message' => __( 'Please write a review.', 'jr-addons' ),
				]
			);
		}

		// Validate rating
		if ( $rating < 1 || $rating > 5 ) {

			wp_send_json_error(
				[
					'message' => __( 'Please select a rating.', 'jr-addons' ),
				]
			);
		}

		$user = wp_get_current_user();

		// Logged in user
		if ( $user && $user->ID ) {

			$name  = $user->display_name;
			$email = $user->user_email;

		} else {

			// Guest user
			$name = isset( $_POST['reviewer_name'] )
				? sanitize_text_field( wp_unslash( $_POST['reviewer_name'] ) )
				: '';

			$email = isset( $_POST['reviewer_email'] )
				? sanitize_email( wp_unslash( $_POST['reviewer_email'] ) )
				: '';

			if ( empty( $name ) || empty( $email ) || ! is_email( $email ) ) {

				wp_send_json_error(
					[
						'message' => __( 'Please provide valid name and email.', 'jr-addons' ),
					]
				);
			}
		}

		// Comment data
		$comment_data = [
			'comment_post_ID'      => $product_id,
			'comment_author'       => $name,
			'comment_author_email' => $email,
			'comment_content'      => $content,
			'comment_type'         => 'review',
			'comment_parent'       => 0,
			'user_id'              => $user->ID,
			'comment_approved'     => get_option( 'comment_moderation' ) ? 0 : 1,
		];

		// Insert comment
		$comment_id = wp_insert_comment( wp_slash( $comment_data ) );

		if ( ! $comment_id ) {

			wp_send_json_error(
				[
					'message' => __( 'Failed to submit review. Try again.', 'jr-addons' ),
				]
			);
		}

		// Save review meta
		update_comment_meta( $comment_id, 'rating', $rating );
		update_comment_meta( $comment_id, 'jr_recommend', $recommend );

		// Refresh WooCommerce review cache
		if ( class_exists( '\WC_Comments' ) ) {

			\WC_Comments::clear_transients( $product_id );
		}

		$approved = (int) $comment_data['comment_approved'];

		wp_send_json_success(
			[
				'message' => $approved
					? __( 'Thank you! Your review has been submitted.', 'jr-addons' )
					: __( 'Thank you! Your review is pending approval.', 'jr-addons' ),

				'approved' => $approved,
			]
		);
	}
}