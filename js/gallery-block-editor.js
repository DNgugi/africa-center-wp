/**
 * Gallery Block Editor Enhancements
 *
 * This file adds controls to the Gallery block in the WordPress editor.
 */
(function (wp) {
  var registerPlugin = wp.plugins.registerPlugin;
  var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
  var el = wp.element.createElement;
  var useSelect = wp.data.useSelect;
  var useDispatch = wp.data.useDispatch;
  var SelectControl = wp.components.SelectControl;
  var ToggleControl = wp.components.ToggleControl;
  var compose = wp.compose.compose;
  var withSelect = wp.data.withSelect;
  var withDispatch = wp.data.withDispatch;

  // Add custom attributes to the gallery block
  wp.hooks.addFilter(
    "blocks.registerBlockType",
    "headless/gallery-attributes",
    function (settings, name) {
      if (name !== "core/gallery") {
        return settings;
      }

      // Add custom attributes
      settings.attributes = Object.assign(settings.attributes, {
        displayAs: {
          type: "string",
          default: "grid",
        },
      });

      return settings;
    }
  );

  // Add custom controls to the gallery block
  var galleryControls = function (BlockEdit) {
    return function (props) {
      // Return the original BlockEdit if it's not a gallery block
      if (props.name !== "core/gallery") {
        return el(BlockEdit, props);
      }

      // Handle style change
      var onStyleChange = function (value) {
        // Update the className to include our custom style
        var newClassName = "is-style-headless-" + value;
        props.setAttributes({
          className: newClassName,
          displayAs: value,
        });
      };

      // Determine the current style
      var currentStyle = "grid"; // Default
      if (
        props.attributes.className &&
        props.attributes.className.includes("is-style-headless-slideshow")
      ) {
        currentStyle = "slideshow";
      }

      // Return the enhanced BlockEdit
      return el(
        wp.element.Fragment,
        {},
        el(BlockEdit, props),
        el(
          wp.blockEditor.InspectorControls,
          {},
          el(
            wp.components.PanelBody,
            { title: "Gallery Display Options", initialOpen: true },
            el(SelectControl, {
              label: "Display As",
              value: currentStyle,
              options: [
                { label: "Grid", value: "grid" },
                { label: "Slideshow", value: "slideshow" },
              ],
              onChange: onStyleChange,
            })
          )
        )
      );
    };
  };

  // Register our custom gallery controls
  wp.hooks.addFilter(
    "editor.BlockEdit",
    "headless/gallery-controls",
    galleryControls
  );
})(window.wp);
