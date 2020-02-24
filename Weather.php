<?php

namespace vnh\widgets;

use vnh\Widget;

class Weather extends Widget {
	public function config() {
		return [
			'id_base' => 'weather',
			'classname' => 'widget-weather',
			'name' => __('Weather', 'vnh_textdomain'),
			'description' => __('Displays weather.', 'vnh_textdomain'),
			'fields' => [
				'title' => [
					'label' => __('Title:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => esc_html__('Weather', 'vnh_textdomain'),
				],
				'address' => [
					'label' => __('Address:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => 'hanoi, vietnam',
				],
				'freq' => [
					'label' => __('Weather Check Interval:', 'vnh_textdomain'),
					'type' => 'select',
					'options' => [
						30 => __('30 minutes', 'vnh_textdomain'),
						60 => __('1 hour', 'vnh_textdomain'),
						120 => __('2 hours', 'vnh_textdomain'),
						180 => __('3 hours', 'vnh_textdomain'),
						240 => __('4 hours', 'vnh_textdomain'),
					],
					'default' => 60,
				],
			],
		];
	}

	public function widget($args, $instance) {
		$this->widget_start($args, $instance);

		if (empty($instance['address'])) {
			printf('<b>%s</b>', esc_html__('Please fill all widget settings!', 'vnh_textdomain'));

			$this->widget_end($args);

			return;
		}

		do_shortcode(
			sprintf(
				'[weather address = %s freq = %s transient_weather = %s transient_coordinates = %s]',
				$instance['address'],
				$instance['freq'],
				$this->id,
				$this->id . '_coordinates'
			)
		);

		$this->widget_end($args);
	}

	public function update($new_instance, $old_instance) {
		if ($old_instance['freq'] !== $new_instance['freq']) {
			delete_transient($this->id);
		}

		if ($old_instance['address'] !== $new_instance['address']) {
			delete_transient($this->id . '_coordinates');
		}

		return $new_instance;
	}
}
