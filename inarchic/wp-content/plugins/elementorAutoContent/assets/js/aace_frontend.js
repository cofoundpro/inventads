(function ($) {
	'use strict';

	$(window).on("elementor/frontend/init", function () {
		
		elementor.channels.editor.on('aace:autocontent:generate', function () {
			if (typeof (window.parent.document) != 'undefined') {
				const id = $('#elementor-controls textarea', window.parent.document).attr('id');
				$('#' + id, window.parent.document).trigger('change');
				const prompt = $('.elementor-control-type-text input[data-setting="aace_prompt"]', window.parent.document).val();
				const keywords = $('.elementor-control-type-text input[data-setting="aace_seo"]', window.parent.document).val();

				if (prompt.trim().length == 0) {
					$('.elementor-control-type-text input[data-setting="aace_prompt"]', window.parent.document).css({ borderColor: '#e74c3c' });
				} else {
					$('.elementor-control-type-text input[data-setting="aace_prompt"]', window.parent.document).css({ borderColor: 'inherit' });

					$('#elementor-controls .elementor-button-default', window.parent.document).prop( "disabled", true );

					$.ajax({
						url: aace_data.ajaxurl,
						type: 'post',
						data: {
							action: 'aace_generateText',
							prompt: prompt,
							keywords: keywords
						},
						success: function (rep) {
							$('#elementor-controls .elementor-button-default', window.parent.document).prop( "disabled", false );
							if (rep.indexOf('error:') == 0) {
								const error = rep.substr(6, rep.length);
								alert(error);
							} else {
								var activeEditor = window.parent.tinyMCE.get(id);
								if (activeEditor !== null) { 
									activeEditor.setContent(rep);
									activeEditor.fire('change');
								}
							}
						},
						error: function (rep) {
							alert(rep);
						}
					});
				}
			}
		});
	});


})(jQuery);
