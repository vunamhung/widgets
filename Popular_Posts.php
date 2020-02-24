<?php

namespace vnh\widgets;

use vnh\Widget;

class Popular_Posts extends Widget {
	public function config() {
		return [
			'id_base' => 'popular',
			'classname' => 'widget-popular-posts',
			'name' => __('Popular Post', 'vnh_textdomain'),
			'description' => __('Display popular post based on number of comments or number of like.', 'vnh_textdomain'),
			'fields' => [
				'title' => [
					'label' => __('Title:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => esc_html__('Popular', 'vnh_textdomain'),
				],
				'number_of_posts' => [
					'label' => __('Number of posts:', 'vnh_textdomain'),
					'type' => 'number',
					'options' => [
						'min' => 1,
						'max' => 10,
					],
					'default' => 5,
				],
				'thumbnail' => [
					'label' => __('Enable thumbnail', 'vnh_textdomain'),
					'type' => 'checkbox',
					'default' => '1',
				],
				'thumbnail_width' => [
					'label' => __('Thumbnail Width:', 'vnh_textdomain'),
					'type' => 'number',
					'options' => [
						'min' => 50,
						'max' => 500,
					],
					'default' => 100,
				],
				'thumbnail_height' => [
					'label' => __('Thumbnail Height:', 'vnh_textdomain'),
					'type' => 'number',
					'options' => [
						'min' => 50,
						'max' => 500,
					],
					'default' => 100,
				],
			],
		];
	}

	public function widget($args, $instance) {
		$this->widget_start($args, $instance);

		do_shortcode(
			sprintf(
				'[popular_posts number_of_posts = %s thumbnail = %s thumbnail_width = %s thumbnail_height = %s]',
				$instance['number_of_posts'],
				$instance['thumbnail'],
				$instance['thumbnail_width'],
				$instance['thumbnail_height']
			)
		);

		$this->widget_end($args);
	}
}
