(function (blocks, blockEditor, components, i18n, element) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;
  var TextareaControl = components.TextareaControl;
  var InspectorControls = blockEditor.InspectorControls;
  var ColorPalette = components.ColorPalette;
  var MediaUpload = blockEditor.MediaUpload;
  var SelectControl = components.SelectControl;
  var RangeControl = components.RangeControl;

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
        default: '#003366'
      },
      backgroundColor: {
        type: 'string',
        default: '#ffffff'
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
        type: 'number',
        default: 10
      },
      margin: {
        type: 'number',
        default: 0
      }
    },

    edit: function (props) {
      return el(
        'div',
        {},
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
            props.attributes.backgroundImage && el('img', {
              src: props.attributes.backgroundImage,
              alt: 'Background Image Thumbnail'
            }),
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
          el(RangeControl, {
            value: props.attributes.padding,
            onChange: function (newPadding) {
              props.setAttributes({ padding: newPadding });
            },
            min: 0,
            max: 100
          })),
          el(components.BaseControl, {
            label: 'Margin'
          },
          el(RangeControl, {
            value: props.attributes.margin,
            onChange: function (newMargin) {
              props.setAttributes({ margin: newMargin });
            },
            min: 0,
            max: 100
          })))
        ),
        el(TextareaControl, {
          label: 'Add Content - Shortcodes work too',
          value: props.attributes.content,
          onChange: function (newContent) {
            props.setAttributes({ content: newContent });
          }
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
          backgroundPosition: 'center',
          backgroundAttachment: 'fixed',
          textAlign: props.attributes.textPosition,
          padding: props.attributes.padding + 'px',
          margin: props.attributes.margin + 'px'
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
