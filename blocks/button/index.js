( function( blocks, editor, element, components, data ) {
    var el = element.createElement;
    const {__} = wp.i18n;
    const { RichText, InspectorControls, MediaUpload, MediaUploadCheck, InnerBlocks, FontSizePicker  } = editor;
	const { Fragment } = element;
	const withSelect = data.withSelect;
	const {
		TextControl,
		CheckboxControl,
		RadioControl,
		SelectControl,
		TextareaControl,
		ToggleControl,
		RangeControl,
		Panel,
		PanelBody,
		PanelRow,
		PanelHeader,
		FormFileUpload,
		Button,
		ColorPicker,
		DropdownMenu
	} = components;


    blocks.registerBlockType( 'lifeline-donation/button', {
        title: __('Donation Button', 'lifeline-donation'),
        description: __( 'Add a donation button anywhere in the website. This button allows to show popup on click and collect donation via form wizard', 'lifeline-donation' ),
 		keywords: [__('Donation', 'lifeline-donation'), __('Lifeline', 'lifeline-donation'), __('Charity', 'lifeline-donation'), __('Non Profit', 'lifeline-donation')],
        icon: 'universal-access-alt',
        category: 'lifeline-donation',
        attributes: {
        	causes: {
        		type: 'array'
        	},
        	height: {
        		type: 'number'
        	},
        	width: {
        		type: 'number'
        	},
        	bg_color: {
        		type: 'string',
        		selector: 'a'
        	},
        	color: {
        		type: 'string',
        		selector: 'a'
        	},
        	icon: {
        		type: 'string',
        		selector: '.icon'
        	},
        	iconslist: {
        		type: 'array',
        	},
            text: {
                type: 'string',
                selector: 'a',
            },
            border_color: {
                type: 'string',
            },
            border_radius: {
                type: 'number',
            },
            margin: {
                type: 'string',
            },
            btn_action: {
                type: 'boolean',
            },
            link: {
                type: 'string',
            },
            post_id: {
                type: 'string',
            },
        },
 
        edit: withSelect( function( select ) {
            return {
                posts: select( 'core' ).getEntityRecords( 'postType', 'cause' )
            };
        } )( function( props ) {

        	const {
		        attributes: {
		            height,
		            width,
		            btn_action,
		            color,
		            border_color,
		            bg_color,
		            post_id,
		            border_radius,
		            icon,
		            causes
		        },
		        setAttributes,
		        toggleSelection,
		    } = props;

		    if( ! props.attributes.causes ) {

			    const getposts = () => {
			    	return new Promise( function(resolve) {
			    		wp.apiFetch( { path : '/wp/v2/cause?post_type=any&per_page=100' } ).then(
		                    function ( res ) {
		                    	resolve(res)
		                    }
		                )
			    	})
			    }

			    let causes = [];
			    getposts().then(opts => {
			    	if(opts) {
			    		opts.map(function(value, index){
			    			causes.push({value: value.id, label: value.title.rendered+'('+value.type+')'})
			    		})
			    		setAttributes({causes: causes})
			    	}
			    });
		    }

		    let btn_class = 'wpcm-custom-button wpcm-btn ' + (props.className) ? props.className : '';
		    if(icon) {
		    	btn_class += ' has-icon';
		    }
		    let padding = (height && width) ? height+'px '+width+'px' : '10px 50px';
		    if( icon ) {
		    	padding = (height && width) ? height+'px '+width+'px '+height+'px '+(width+40)+'px' : '10px 90px';
		    }
            let btn_object = {
				className: btn_class,
				href: '#',
				style: {
					background: (props.attributes.bg_color) ? props.attributes.bg_color+' no-repeat' : 'transparent no-repeat',
					color: (props.attributes.color) ? props.attributes.color : '#fff',
					borderColor: (props.attributes.border_color) ? props.attributes.border_color : '#555',
					padding: padding,
					borderRadius: (border_radius) ? border_radius+'px' : '0px' 
				},
			};

			if( btn_action ) {
				btn_object['@click.prevent'] = 'showModal('+post_id+', $event)';
			}
			if( btn_action && post_id ) {
				btn_object['data-post'] = post_id
			}
			if( ! bg_color || bg_color == 'transparent' ) {
				btn_object.style.textDecoration = 'underline'
				btn_object.style.textTransform = 'initial'
			}


            return [
                el( Fragment, {},
					el( InspectorControls, {},
						el( PanelBody, { title: 'Form Settings', initialOpen: true },
		 
							/* Text Field */
							el( PanelRow, {},
								el( 'label', {}, __('Background Color', 'Lifeline_Donation')	)
							),
							el( PanelRow, {},
								el( ColorPicker,
									{
										onChangeComplete: ( value ) => {
											props.setAttributes( { bg_color: value.hex } );
										},
										value: props.attributes.bg_color
									}
								)
							),
		 					el( PanelRow, {},
								el( 'label', {}, __('Text Color', 'Lifeline_Donation')	)
							),
							/* Toggle Field */
							el( PanelRow, {},
								el( ColorPicker,
									{
										onChangeComplete: ( value ) => {
											props.setAttributes( { color: value.hex } );
										},
										checked: props.attributes.color,
									}
								)
							),
							el( PanelRow, {},
								el( 'label', {}, __('Border Color', 'Lifeline_Donation')	)
							),
							el( PanelRow, {},
								el( ColorPicker,
									{
										onChangeComplete: ( value ) => {
											props.setAttributes( { border_color: value.hex } );
										},
										checked: props.attributes.border_color,
									}
								)
							),
							el( PanelRow, {},
								el( RangeControl,
									{
										label: __('Padding (Top/Bottom)', 'Lifeline_Donation'),
										value: height,
										onChange: (newvalue) => {
											props.setAttributes({height: newvalue})
										},
										min: 2,
									}
								)
							),
							el( PanelRow, {},
								el( RangeControl,
									{
										label: __('Padding (left/right)', 'Lifeline_Donation'),
										value: width,
										onChange: (newvalue) => {
											props.setAttributes({width: newvalue})
										},
										min: 2,
									}
								)
							),
							el( PanelRow, {},
								el( RangeControl,
									{
										label: __('Border Radius', 'Lifeline_Donation'),
										value: border_radius,
										onChange: (newvalue) => {
											props.setAttributes({border_radius: newvalue})
										},
										min: 0,
									}
								)
							),
							el( PanelRow, {},
								el( ToggleControl,
									{
										label: __('Enable Donation Popup', 'Lifeline_Donation'),
										checked: btn_action,
										onChange: (newvalue) => {
											console.log(props.attributes.btn_action);
											props.setAttributes({btn_action: ! props.attributes.btn_action })
										},
									}
								)
							),
							el( PanelRow, {},
								el( SelectControl,
									{
										label: __('Choose Donation Post', 'Lifeline_Donation'),
										options: (props.attributes.causes) ? props.attributes.causes : [],
										onChange: (newvalue) => {
											props.setAttributes({post_id: newvalue})
										},
										value: props.attributes.post_id
									}
								)
							),
							el( PanelRow, {},
								el( 'label', {}, __('Choose Icon', 'Lifeline_Donation')	)
							),
							el( PanelRow, {},
								el( DropdownMenu,
									{
										label: __('Choose Icon', 'Lifeline_Donation'),
										icon: (props.attributes.icon) ? props.attributes.icon : 'info',
										controls: [
											{icon: 'info', title: __('No Icon'), onClick: () => {props.setAttributes({icon: ''})}},
											{icon: 'arrow-right-alt', title: __('Drop'), onClick: () => {props.setAttributes({icon: 'arrow-right-alt'})}},
											{icon: 'location', title: __('Location'), onClick: () => {props.setAttributes({icon: 'location'})} },
										],
									}
								)
							)
						)
					)
				),
				el('a', 
					btn_object,
					(icon) ? el('i', {
						className: 'dashicons dashicons-'+icon
					}) : '',
					el( RichText,
	                    {
	                        key: 'richtext',
	                        style: { textAlign: 'center' },
	                        onChange: (newcontent) => {
	                        	props.setAttributes( { text: newcontent } );
	                        },
	                        value: props.attributes.text,
	                    }
					)
 				)
            ];
        }),
 
        save: function( props ) {
        	const {
        		attributes: {
		            height,
		            width,
		            btn_action,
		            color,
		            border_color,
		            bg_color,
		            post_id,
		            text,
		            border_radius,
		            icon
		        },
        	} = props

        	let btn_class = 'wpcm-custom-button wpcm-btn ' + (props.className) ? props.className : '';
		    if(icon) {
		    	btn_class += ' has-icon';
		    }
		    let padding = (height && width) ? height+'px '+width+'px' : '10px 50px';
		    if( icon ) {
		    	padding = (height && width) ? height+'px '+width+'px '+height+'px '+(width+40)+'px' : '10px 90px';
		    }

        	let btn_object = {
				className: btn_class,
				href: '#',
				style: {
					background: (props.attributes.bg_color) ? props.attributes.bg_color+' no-repeat' : 'transparent no-repeat',
					color: (props.attributes.color) ? props.attributes.color : '#fff',
					borderColor: (props.attributes.border_color) ? props.attributes.border_color : '#555',
					padding: padding,
					borderRadius: (border_radius) ? border_radius+'px' : '0px' 
				},
			};

			if( btn_action ) {
				btn_object['@click.prevent'] = 'showModal('+post_id+', $event)';
			}
			if( btn_action && post_id ) {
				btn_object['data-post'] = post_id
			}
			if( ! bg_color || bg_color == 'transparent' ) {
				btn_object.style.textDecoration = 'underline'
				btn_object.style.textTransform = 'initial'
			}

        	return el('a', 
				btn_object,
				(icon) ? el('i', {
					className: 'dashicons dashicons-'+icon
				}) : '',
				el( RichText.Content, 
	            	{
		                tagName: 'span',
		                value: text,
		            }
		            
	            )
			);
        },
    } );
}(
    window.wp.blocks,
    window.wp.blockEditor,
    window.wp.element,
    window.wp.components,
    window.wp.data
) );