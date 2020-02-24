<?php

namespace vnh\widgets;

use vnh\Widget;

class Twitter extends Widget {
	public function config() {
		return [
			'id_base' => 'tweet',
			'classname' => 'widget-latest-tweets',
			'name' => __('Latest Tweets', 'vnh_textdomain'),
			'description' => __('Displays your latest tweets.', 'vnh_textdomain'),
			'fields' => [
				'title' => [
					'label' => __('Title:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => esc_html__('Latest Tweet', 'vnh_textdomain'),
				],
				'username' => [
					'label' => __('Username', 'vnh_textdomain'),
					'type' => 'text',
					'default' => 'unsplash',
				],
				'count' => [
					'label' => __('Number of tweets:', 'vnh_textdomain'),
					'type' => 'number',
					'options' => [
						'min' => 1,
						'max' => 12,
					],
					'default' => 3,
				],
			],
		];
	}

	public function widget($args, $instance) {
		$this->widget_start($args, $instance);

		if (empty($instance['username'])) {
			printf('<b>%s</b>', esc_html__('Please fill all widget settings!', 'vnh_textdomain'));

			$this->widget_end($args);

			return;
		}

		do_shortcode(
			sprintf('[latest_tweet username = %s count = %s transient_name = %s ]', $instance['username'], $instance['count'], $this->id)
		);

		$this->widget_end($args);
	}

	public function update($new_instance, $old_instance) {
		if ($old_instance['username'] !== $new_instance['username'] || $old_instance['count'] !== $new_instance['count']) {
			delete_transient($this->id);
		}

		return $new_instance;
	}
}
