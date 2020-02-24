<?php

namespace vnh\widgets;

use vnh\Widget;

class Better_Menu extends Widget {
	public function config() {
		return [
			'id_base' => 'better_menu',
			'classname' => 'widget-better-menu',
			'name' => __('Better Menu', 'vnh_textdomain'),
			'description' => __('Display custom menu.', 'vnh_textdomain'),
			'fields' => [
				'title' => [
					'label' => __('Title:', 'vnh_textdomain'),
					'type' => 'text',
					'default' => __('Better Menu', 'vnh_textdomain'),
				],
				'nav_menu' => [
					'label' => __('Select Menu:', 'vnh_textdomain'),
					'type' => 'select',
					'subtype' => 'taxonomy',
					'options' => [
						'taxonomy' => 'nav_menu',
						'hide_empty' => false,
					],
				],
			],
		];
	}

	/**
	 * @param array $args
	 * @param array $instance
	 * @uses fallback
	 */
	public function widget($args, $instance) {
		$this->widget_start($args, $instance);

		wp_nav_menu([
			'container' => '',
			'menu_class' => 'better-menu',
			'menu' => wp_get_nav_menu_object($instance['nav_menu']),
			'fallback_cb' => [$this, 'fallback'],
		]);

		$this->widget_end($args);
	}

	public function fallback() {
		printf(
			'<p>%1$s <a href="%2$s">%3$s</a>.</p>',
			esc_html__('No menus have been created yet', 'vnh_textdomain'),
			esc_url(admin_url('nav-menus.php')),
			esc_html__('Create some', 'vnh_textdomain')
		);
	}
}
