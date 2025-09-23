const { registerBlockType } = wp.blocks;
const { InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const {
  PanelBody,
  SelectControl,
  RangeControl,
  ToggleControl,
  TextControl,
  Button,
  TextareaControl,
  ColorPalette,
} = wp.components;
const { Fragment } = wp.element;
const { __ } = wp.i18n;

// Colors for components
const colorOptions = [
  { name: "White", color: "#ffffff" },
  { name: "Light", color: "#f3f4f6" },
  { name: "Primary", color: "#3b82f6" },
  { name: "Dark", color: "#111827" },
];

// Register Hero Block
registerBlockType("headless/hero", {
  title: __("Hero"),
  icon: "cover-image",
  category: "headless-components",
  attributes: {
    title: {
      type: "string",
      default: "",
    },
    subtitle: {
      type: "string",
      default: "",
    },
    description: {
      type: "string",
      default: "",
    },
    background_image: {
      type: "number",
      default: 0,
    },
    overlay_opacity: {
      type: "number",
      default: 50,
    },
    button_text: {
      type: "string",
      default: "",
    },
    button_url: {
      type: "string",
      default: "",
    },
    height: {
      type: "string",
      default: "medium",
    },
    text_alignment: {
      type: "string",
      default: "center",
    },
  },
  edit: function (props) {
    const { attributes, setAttributes } = props;

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("Hero Settings")}>
            <TextControl
              label={__("Title")}
              value={attributes.title}
              onChange={(title) => setAttributes({ title })}
            />
            <TextControl
              label={__("Subtitle")}
              value={attributes.subtitle}
              onChange={(subtitle) => setAttributes({ subtitle })}
            />
            <TextareaControl
              label={__("Description")}
              value={attributes.description}
              onChange={(description) => setAttributes({ description })}
            />
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) =>
                  setAttributes({ background_image: media.id })
                }
                allowedTypes={["image"]}
                value={attributes.background_image}
                render={({ open }) => (
                  <Button
                    onClick={open}
                    className="editor-post-featured-image__toggle"
                  >
                    {attributes.background_image === 0
                      ? __("Add Background Image")
                      : __("Change Background Image")}
                  </Button>
                )}
              />
            </MediaUploadCheck>
            <RangeControl
              label={__("Overlay Opacity")}
              value={attributes.overlay_opacity}
              onChange={(overlay_opacity) => setAttributes({ overlay_opacity })}
              min={0}
              max={100}
            />
            <TextControl
              label={__("Button Text")}
              value={attributes.button_text}
              onChange={(button_text) => setAttributes({ button_text })}
            />
            <TextControl
              label={__("Button URL")}
              value={attributes.button_url}
              onChange={(button_url) => setAttributes({ button_url })}
            />
            <SelectControl
              label={__("Height")}
              value={attributes.height}
              options={[
                { label: "Small", value: "small" },
                { label: "Medium", value: "medium" },
                { label: "Large", value: "large" },
                { label: "Full Screen", value: "full" },
              ]}
              onChange={(height) => setAttributes({ height })}
            />
            <SelectControl
              label={__("Text Alignment")}
              value={attributes.text_alignment}
              options={[
                { label: "Left", value: "left" },
                { label: "Center", value: "center" },
                { label: "Right", value: "right" },
              ]}
              onChange={(text_alignment) => setAttributes({ text_alignment })}
            />
          </PanelBody>
        </InspectorControls>
        <div className={`wp-block-headless-hero height-${attributes.height}`}>
          <div className="placeholder">
            {__("Hero Component")}
            <br />
            {attributes.title && <strong>{attributes.title}</strong>}
          </div>
        </div>
      </Fragment>
    );
  },
  save: function () {
    return null;
  },
});

// Register Team Members Block
registerBlockType("headless/team-members", {
  title: __("Team Members"),
  icon: "groups",
  category: "headless-components",
  attributes: {
    layout_style: {
      type: "string",
      default: "grid",
    },
    columns: {
      type: "number",
      default: 3,
    },
    show_social: {
      type: "boolean",
      default: true,
    },
    category: {
      type: "string",
      default: "",
    },
    limit: {
      type: "number",
      default: -1,
    },
  },
  edit: function (props) {
    const { attributes, setAttributes } = props;

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("Team Members Settings")}>
            <SelectControl
              label={__("Layout Style")}
              value={attributes.layout_style}
              options={[
                { label: "Grid", value: "grid" },
                { label: "List", value: "list" },
              ]}
              onChange={(layout_style) => setAttributes({ layout_style })}
            />
            <RangeControl
              label={__("Columns")}
              value={attributes.columns}
              onChange={(columns) => setAttributes({ columns })}
              min={1}
              max={4}
            />
            <ToggleControl
              label={__("Show Social Links")}
              checked={attributes.show_social}
              onChange={(show_social) => setAttributes({ show_social })}
            />
            <TextControl
              label={__("Category")}
              value={attributes.category}
              onChange={(category) => setAttributes({ category })}
            />
            <RangeControl
              label={__("Limit")}
              value={attributes.limit}
              onChange={(limit) => setAttributes({ limit })}
              min={-1}
              max={50}
            />
          </PanelBody>
        </InspectorControls>
        <div
          className={`wp-block-headless-team-members layout-${attributes.layout_style}`}
        >
          <div className="placeholder">
            {__("Team Members Component")}
            <br />
            {__("Content will be dynamically loaded on the frontend")}
          </div>
        </div>
      </Fragment>
    );
  },
  save: function () {
    return null; // Dynamic block, render callback on server
  },
});

// Register Events Block
registerBlockType("headless/events", {
  title: __("Events"),
  icon: "calendar",
  category: "headless-components",
  attributes: {
    layout_style: {
      type: "string",
      default: "grid",
    },
    show_filters: {
      type: "boolean",
      default: true,
    },
    category: {
      type: "string",
      default: "",
    },
    limit: {
      type: "number",
      default: -1,
    },
    orderby: {
      type: "string",
      default: "event_date",
    },
    order: {
      type: "string",
      default: "ASC",
    },
  },
  edit: function (props) {
    const { attributes, setAttributes } = props;

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("Events Settings")}>
            <SelectControl
              label={__("Layout Style")}
              value={attributes.layout_style}
              options={[
                { label: "Grid", value: "grid" },
                { label: "List", value: "list" },
              ]}
              onChange={(layout_style) => setAttributes({ layout_style })}
            />
            <ToggleControl
              label={__("Show Filters")}
              checked={attributes.show_filters}
              onChange={(show_filters) => setAttributes({ show_filters })}
            />
            <TextControl
              label={__("Category")}
              value={attributes.category}
              onChange={(category) => setAttributes({ category })}
            />
            <RangeControl
              label={__("Limit")}
              value={attributes.limit}
              onChange={(limit) => setAttributes({ limit })}
              min={-1}
              max={50}
            />
            <SelectControl
              label={__("Order By")}
              value={attributes.orderby}
              options={[
                { label: "Event Date", value: "event_date" },
                { label: "Title", value: "title" },
              ]}
              onChange={(orderby) => setAttributes({ orderby })}
            />
            <SelectControl
              label={__("Order")}
              value={attributes.order}
              options={[
                { label: "Ascending", value: "ASC" },
                { label: "Descending", value: "DESC" },
              ]}
              onChange={(order) => setAttributes({ order })}
            />
          </PanelBody>
        </InspectorControls>
        <div
          className={`wp-block-headless-events layout-${attributes.layout_style}`}
        >
          <div className="placeholder">
            {__("Events Component")}
            <br />
            {__("Content will be dynamically loaded on the frontend")}
          </div>
        </div>
      </Fragment>
    );
  },
  save: function () {
    return null; // Dynamic block, render callback on server
  },
});

// Register Cultural Items Block
registerBlockType("headless/cultural-items", {
  title: __("Cultural Items"),
  icon: "art",
  category: "headless-components",
  attributes: {
    layout_style: {
      type: "string",
      default: "grid",
    },
    show_filters: {
      type: "boolean",
      default: true,
    },
    masonry: {
      type: "boolean",
      default: false,
    },
    category: {
      type: "string",
      default: "",
    },
    limit: {
      type: "number",
      default: -1,
    },
  },
  edit: function (props) {
    const { attributes, setAttributes } = props;

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("Cultural Items Settings")}>
            <SelectControl
              label={__("Layout Style")}
              value={attributes.layout_style}
              options={[
                { label: "Grid", value: "grid" },
                { label: "List", value: "list" },
              ]}
              onChange={(layout_style) => setAttributes({ layout_style })}
            />
            <ToggleControl
              label={__("Show Filters")}
              checked={attributes.show_filters}
              onChange={(show_filters) => setAttributes({ show_filters })}
            />
            <ToggleControl
              label={__("Enable Masonry Layout")}
              checked={attributes.masonry}
              onChange={(masonry) => setAttributes({ masonry })}
            />
            <TextControl
              label={__("Category")}
              value={attributes.category}
              onChange={(category) => setAttributes({ category })}
            />
            <RangeControl
              label={__("Limit")}
              value={attributes.limit}
              onChange={(limit) => setAttributes({ limit })}
              min={-1}
              max={50}
            />
          </PanelBody>
        </InspectorControls>
        <div
          className={`wp-block-headless-cultural-items layout-${attributes.layout_style}`}
        >
          <div className="placeholder">
            {__("Cultural Items Component")}
            <br />
            {__("Content will be dynamically loaded on the frontend")}
          </div>
        </div>
      </Fragment>
    );
  },
  save: function () {
    return null; // Dynamic block, render callback on server
  },
});

// Register News Grid Block
registerBlockType("headless/news-grid", {
  title: __("News Grid"),
  icon: "grid-view",
  category: "headless-components",
  attributes: {
    layout_style: {
      type: "string",
      default: "grid",
    },
    show_filters: {
      type: "boolean",
      default: true,
    },
    show_categories: {
      type: "boolean",
      default: true,
    },
    show_excerpt: {
      type: "boolean",
      default: true,
    },
    excerpt_length: {
      type: "number",
      default: 20,
    },
    category: {
      type: "string",
      default: "",
    },
    limit: {
      type: "number",
      default: 9,
    },
  },
  edit: function (props) {
    const { attributes, setAttributes } = props;

    return (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("News Grid Settings")}>
            <SelectControl
              label={__("Layout Style")}
              value={attributes.layout_style}
              options={[
                { label: "Grid", value: "grid" },
                { label: "List", value: "list" },
              ]}
              onChange={(layout_style) => setAttributes({ layout_style })}
            />
            <ToggleControl
              label={__("Show Filters")}
              checked={attributes.show_filters}
              onChange={(show_filters) => setAttributes({ show_filters })}
            />
            <ToggleControl
              label={__("Show Categories")}
              checked={attributes.show_categories}
              onChange={(show_categories) => setAttributes({ show_categories })}
            />
            <ToggleControl
              label={__("Show Excerpt")}
              checked={attributes.show_excerpt}
              onChange={(show_excerpt) => setAttributes({ show_excerpt })}
            />
            <RangeControl
              label={__("Excerpt Length")}
              value={attributes.excerpt_length}
              onChange={(excerpt_length) => setAttributes({ excerpt_length })}
              min={10}
              max={100}
            />
            <TextControl
              label={__("Category")}
              value={attributes.category}
              onChange={(category) => setAttributes({ category })}
            />
            <RangeControl
              label={__("Limit")}
              value={attributes.limit}
              onChange={(limit) => setAttributes({ limit })}
              min={1}
              max={50}
            />
          </PanelBody>
        </InspectorControls>
        <div
          className={`wp-block-headless-news-grid layout-${attributes.layout_style}`}
        >
          <div className="placeholder">
            {__("News Grid Component")}
            <br />
            {__("Content will be dynamically loaded on the frontend")}
          </div>
        </div>
      </Fragment>
    );
  },
  save: function () {
    return null; // Dynamic block, render callback on server
  },
});
