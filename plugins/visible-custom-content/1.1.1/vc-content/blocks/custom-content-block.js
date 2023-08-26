(function (blocks, blockEditor, components, i18n, element) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;
  var TextareaControl = components.TextareaControl;
  var InspectorControls = blockEditor.InspectorControls;
  var ColorPalette = components.ColorPalette;
  var MediaUpload = blockEditor.MediaUpload;
  var SelectControl = components.SelectControl;
  var RangeControl = components.RangeControl;
  var TextControl = components.TextControl;



  registerBlockType('custom-content-plugin/custom-content-block', {
    title: 'Custom Content',
    icon: 'shield',
    category: 'design',
    attributes: {
      content: {
        type: 'string',
        default: ''
      },
      textColor: {
        type: 'string',
        default: ''
      },
      backgroundColor: {
        type: 'string',
        default: '#003366'
      },
      backgroundImage: {
        type: 'string',
        default: ''
      },
      textPosition: {
        type: 'string',
        default: 'center'
      },
      padding: {
        type: 'string',
        default: '2em 0 2.5em'
      },
      margin: {
        type: 'string',
        default: '15px auto 17px auto'
      },
      backgroundPosition: {
        type: 'string',
        default: 'center'
      },
      backgroundAttachment: {
        type: 'string',
        default: 'fixed'
      }
    },
	borderRadius: {
        type: 'numer',
        default: '7'
      },

    edit: function (props) {
      return el(
        'div',
        {className: 'dascent-custom-block-wrapper'},		
        el(InspectorControls, {},
          el(components.PanelBody, {
            title: 'Custom Content Settings',
            initialOpen: true,
          },
          el(components.BaseControl, {
            label: 'Text Color'
          },
          el(ColorPalette, {
            value: props.attributes.textColor,
            onChange: function (newColor) {
              props.setAttributes({ textColor: newColor });
            }
          })),
          el(components.BaseControl, {
            label: 'Background Color'
          },
          el(ColorPalette, {
            value: props.attributes.backgroundColor,
            onChange: function (newColor) {
              props.setAttributes({ backgroundColor: newColor });
            }
          })),
          el(components.BaseControl, {
            label: 'Background Image'
          },
          el('div', { className: 'background-image-control' }, [
            props.attributes.backgroundImage && [
              el('img', {
                src: props.attributes.backgroundImage,
                alt: 'Background Image Thumbnail'
              }),
              el(components.Button, {
                className: 'remove-background-image-button',
                onClick: function () {
                  props.setAttributes({ backgroundImage: '' });
                }
              }, 'Remove Background Image')
            ],
            el(MediaUpload, {
              onSelect: function (newImage) {
                props.setAttributes({ backgroundImage: newImage.url });
              },
              allowedTypes: 'image',
              value: props.attributes.backgroundImage,
              render: function (obj) {
                return el(components.Button, {
                  onClick: obj.open
                },
                'Select Background Image');
              }
            })
          ])),
          el(components.BaseControl, {
            label: 'Text Position'
          },
          el(SelectControl, {
            options: [
              { label: 'Left', value: 'left' },
              { label: 'Center', value: 'center' },
              { label: 'Right', value: 'right' }
            ],
            value: props.attributes.textPosition,
            onChange: function (newPosition) {
              props.setAttributes({ textPosition: newPosition });
            }
          })),
          el(components.BaseControl, {
            label: 'Padding'
          },
          el(TextControl, {
            value: props.attributes.padding,
            onChange: function (newPadding) {
              props.setAttributes({ padding: newPadding });
            },
            placeholder: '15px 0 15px'
          })),
          el(components.BaseControl, {
            label: 'Margin'
          },
          el(TextControl, {
            value: props.attributes.margin,
            onChange: function (newMargin) {
              props.setAttributes({ margin: newMargin });
            },
            placeholder: '10px auto 22px auto'
          })),
          el(components.BaseControl, {
            label: 'Background Position'
          },
          el(SelectControl, {
            options: [
              { label: 'Top Left', value: 'top left' },
              { label: 'Center', value: 'center' },
              { label: 'Top Right', value: 'top right' },
              { label: 'Bottom Left', value: 'bottom left' },
              { label: 'Bottom Right', value: 'bottom right' },
            ],
            value: props.attributes.backgroundPosition,
            onChange: function (newPosition) {
              props.setAttributes({ backgroundPosition: newPosition });
            }
          })),
		  
		  el(components.BaseControl, {
            label: 'Border Radius'
          },
          el(RangeControl, {
            value: parseInt(props.attributes.borderRadius), // Convertim valoarea într-un număr întreg
            onChange: function (newBorderRadius) {
              props.setAttributes({ borderRadius: newBorderRadius + 'px' }); // Adăugăm 'px sau %'
            },
            min: 0,
            max: 100, // Valori minime și maxime pentru radius
          })),
		  
          el(components.BaseControl, {
            label: 'Background Attachment'
          },
          el(SelectControl, {
            options: [
              { label: 'Scroll', value: 'scroll' },
              { label: 'Fixed', value: 'fixed' },
              { label: 'Local', value: 'local' }
            ],
            value: props.attributes.backgroundAttachment,
            onChange: function (newAttachment) {
              props.setAttributes({ backgroundAttachment: newAttachment });
            }
          })))
        ),
		
        el(TextareaControl, {
  label: 'Add Content - Shortcodes work too',
  value: props.attributes.content,
  onChange: function (newContent) {
    props.setAttributes({ content: newContent });
  },
  style: { 
  borderBottom: '1px solid #ccc',
  background: '#fafcfb',
  minHeight: '250px',
  boxShadow: '0 -25px 1px #f1f1f1',
  borderRadius: '0 0 7px 7px',
  fontSize: '14px',
  fontFamily: 'sans-serif',
  },
  className: 'dascent-blockwrapper'
})
      );
    },
    save: function (props) {
  return el('div', {
    style: {
      color: props.attributes.textColor,
      backgroundColor: props.attributes.backgroundColor,
      backgroundImage: props.attributes.backgroundImage ? 'url(' + props.attributes.backgroundImage + ')' : 'none',
      backgroundSize: 'cover',
      backgroundPosition: props.attributes.backgroundPosition,
      backgroundAttachment: props.attributes.backgroundAttachment,
      textAlign: props.attributes.textPosition,
      padding: props.attributes.padding,
      margin: props.attributes.margin,
      borderRadius: props.attributes.borderRadius,
    },
    dangerouslySetInnerHTML: {
      __html: props.attributes.content.replace(/\n/g, '<br>')
    }
  });
}
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.element
);

