<?php

namespace vnh\widgets;

use vnh\Widget;

class Instagram extends Widget {
	public function config() {
		return [
			'id_base' => 'instagram',
			'classname' => 'widget-instagram',
			'name' => __('Instagram', 'vnh_textdomain'),
			'description' => __('Displays your latest instagram photos.', 'vnh_textdomain'),
			'fields' => [
				'title' => [
					'label' => __('Title:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => esc_html__('Latest Instagram Photos', 'vnh_textdomain'),
				],
				'username' => [
					'label' => __('Username', 'vnh_textdomain'),
					'type' => 'text',
					'default' => 'unsplash',
				],
				'number' => [
					'label' => __('Number of photos:', 'vnh_textdomain'),
					'type' => 'number',
					'options' => [
						'min' => 1,
						'max' => 12,
					],
					'default' => 6,
				],
				'size' => [
					'label' => __('Photo size:', 'vnh_textdomain'),
					'type' => 'select',
					'options' => [
						'thumbnail' => esc_html__('Thumbnail', 'vnh_textdomain'),
						'small' => esc_html__('Small', 'vnh_textdomain'),
						'large' => esc_html__('Large', 'vnh_textdomain'),
						'original' => esc_html__('Original', 'vnh_textdomain'),
					],
					'default' => 'large',
				],
			],
		];
	}

	public function widget($args, $instance) {
		$this->widget_start($args, $instance);

		if (empty($instance['username']) || empty($instance['number']) || empty($instance['size'])) {
			printf('<b>%s</b>', esc_html__('Please fill all widget settings!', 'vnh_textdomain'));

			$this->widget_end($args);

			return;
		}

		do_shortcode(
			sprintf(
				'[instagram username = %s number = %s size = %s transient_name = %s ]',
				$instance['username'],
				$instance['number'],
				$instance['size'],
				$this->id
			)
		);

		$this->widget_end($args);
	}

	public function update($new_instance, $old_instance) {
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['username'] = sanitize_text_field($new_instance['username']);
		$instance['number'] = (int) $new_instance['number'] !== 0 ? (int) $new_instance['number'] : null;
		if (in_array($new_instance['size'], ['thumbnail', 'small', 'large', 'original'], true)) {
			$instance['size'] = $new_instance['size'];
		} else {
			$instance['size'] = 'large';
		}

		if (
			$old_instance['username'] !== $new_instance['username'] ||
			$old_instance['number'] !== $new_instance['number'] ||
			$old_instance['size'] !== $new_instance['size']
		) {
			delete_transient($this->id);
		}

		return $new_instance;
	}
}
