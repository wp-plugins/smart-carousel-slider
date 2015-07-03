

(function() {
	tinymce.PluginManager.add('tp_slider_button', function( editor, url ) {
		editor.addButton( 'tp_slider_button', {
			icon: 'chukku',
			type: 'menubutton',
			title : 'Smart Slider',
					menu: [
						{
							text: 'Carosul Slider',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert Carosul Slider Shortcode',
									width: 600,
									height: 350,
									body: [
										{
											type: 'textbox',
											name: 'sliderID',
											label: 'Slider ID',
											value: 'Write Anything'
											
										},
										{
											type: 'listbox',
											name: 'SliderNavigation',
											label: 'Select Navigation',
											'values': [
												{text: 'Off', value: 'false'},											
												{text: 'On', value: 'true'}
											]
										},
										{
											type: 'listbox',
											name: 'SliderPagination',
											label: 'Select Pagination',
											'values': [
												{text: 'On', value: 'true'},
												{text: 'Off', value: 'false'}
											]
										},
										{
											type: 'listbox',
											name: 'SliderContent',
											label: 'Slider Content',
											'values': [
												{text: 'Off', value: 'none'},											
												{text: 'On', value: 'block'}
											]
										},
										{
											type: 'listbox',
											name: 'SliderEffect',
											label: 'Carosul Effect',
											'values': [
												{text: 'Fade', value: 'fade'},
												{text: 'Back Slide', value: 'backSlide'},
												{text: 'Go Down', value: 'goDown'},
												{text: 'Fade Up', value: 'fadeUp'}
											]
										},
										{
											type: 'listbox',
											name: 'SliderPostType',
											label: 'Carosul Type',
											'values': [
												{text: 'Custom Post', value: 'tp-slider-items'},
												{text: 'Post', value: 'Post'}
											]
										},
										{
											type: 'textbox',
											name: 'SliderPostCategory',
											label: 'Post Category'
										},
										{
											type: 'textbox',
											name: 'SlidercustomCategory',
											label: 'Custom Category'
										}										
									],
									onsubmit: function( e ) {
										editor.insertContent( '[tp_slider id="' + e.data.sliderID + '" navigation="' + e.data.SliderNavigation + '" pagination="' + e.data.SliderPagination + '" contentstyle="' + e.data.SliderContent + '" effect="' + e.data.SliderEffect + '" post_type="' + e.data.SliderPostType + '" post_category="' + e.data.SliderPostCategory + '" custom_category="' + e.data.SlidercustomCategory + '"]');
									}
								});
							}
						}
					]
		});
	});
})();

