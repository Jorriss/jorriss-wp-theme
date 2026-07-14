/**
 * Adds a dedicated "Masthead Lede" panel to the Page editor sidebar.
 *
 * It reads/writes the page excerpt, which the `jorriss/lede` block binding
 * renders as the subtitle line in the dark masthead. This gives authors an
 * obvious, always-visible field instead of hunting for the core Excerpt panel
 * (which is hidden by default on Pages and moves around between WP versions).
 */
( function ( wp ) {
	if ( ! wp || ! wp.plugins || ! wp.element ) {
		return;
	}

	var el = wp.element.createElement;
	var registerPlugin = wp.plugins.registerPlugin;
	// PluginDocumentSettingPanel moved from wp.editPost to wp.editor in WP 6.6.
	var PluginDocumentSettingPanel =
		( wp.editor && wp.editor.PluginDocumentSettingPanel ) ||
		( wp.editPost && wp.editPost.PluginDocumentSettingPanel );
	var TextareaControl = wp.components.TextareaControl;
	var useSelect = wp.data.useSelect;
	var useDispatch = wp.data.useDispatch;

	if ( ! PluginDocumentSettingPanel ) {
		return;
	}

	function LedePanel() {
		var postType = useSelect( function ( select ) {
			return select( 'core/editor' ).getCurrentPostType();
		}, [] );

		var excerpt = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'excerpt' );
		}, [] );

		var editPost = useDispatch( 'core/editor' ).editPost;

		// Only relevant for pages (which use the plain/featured page mastheads).
		if ( postType !== 'page' ) {
			return null;
		}

		return el(
			PluginDocumentSettingPanel,
			{ name: 'jorriss-lede', title: 'Masthead Lede' },
			el( TextareaControl, {
				label: 'Lede',
				help: 'Short line shown under the title in the dark masthead. Leave blank to hide it.',
				value: excerpt || '',
				onChange: function ( value ) {
					editPost( { excerpt: value } );
				},
			} )
		);
	}

	registerPlugin( 'jorriss-lede-panel', { render: LedePanel } );
} )( window.wp );
