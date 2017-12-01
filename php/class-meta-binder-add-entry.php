<?php
/**
 * Class Meta_Binder_Add_Entry
 *
 * @package mkdo\external_links_for_binder
 */

namespace mkdo\external_links_for_binder;

/**
 * Register the Binder Add Entry Meta
 */
class Meta_Binder_Add_Entry {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Do Work
	 */
	public function run() {
		add_filter( 'mkdo_binder_entry_options', array( $this, 'mkdo_binder_entry_options' ), 0, 1 );
		add_action( 'mkdo_binder_add_entry_region', array( $this, 'mkdo_binder_add_entry_region' ), 0 );
		add_action( 'mkdo_binder_after_add_entry_save', array( $this, 'mkdo_binder_after_add_entry_save' ), 0, 1 );
	}

	/**
	 * Filter the entry options
	 *
	 * @param array $options Array of options.
	 * @return array         Modified array of options
	 */
	public function mkdo_binder_entry_options( $options ) {
		$options['external'] = 'External Document';
		return $options;
	}

	/**
	 * Add Entry
	 */
	public function mkdo_binder_add_entry_region() {

		global $post;

		// If the binder prefix dosnt exit, bail.
		if ( ! defined( 'MKDO_BINDER_PREFIX' ) ) {
			return $post_id;
		}

		// Get the document type list.
		$types_list = array();
		$types      = get_terms(
			'binder_type',
			array(
			    'hide_empty' => false,
			)
		);

		// Setup the document type list.
		if ( is_array( $types ) ) {
			foreach ( $types as $type ) {
				$type_icon = get_term_meta( $type->term_id, MKDO_BINDER_PREFIX . '_type_icon', true );
				if ( is_array( $type_icon ) ) {
					$type_icon = $type_icon[0];
				}
				$types_list[ $type->slug ] = '<i class="fa fa-' . $type_icon . '"></i> - ' . $type->name;
			}
		}

		?>
		<div class="meta-box__region meta-box__region--external-document" style="display:none;">

			<div class="meta-box__item meta-box__item--external-document-type">
				<p>
					<label for="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_type">
						<?php esc_html_e( 'Document Type', 'external-links-for-binder' );?>
					</label>
				</p>
				<ul>
					<?php
					// Output the document type list.
					foreach ( $types_list as $key => $type ) {
					?>
					<li>
						<label for="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_type_<?php echo esc_attr( $key );?>">
							<input
								type="radio"
								id="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_type_<?php echo esc_attr( $key );?>"
								name="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_type"
								value="<?php echo esc_attr( $key );?>"
							/>
							<?php
							echo wp_kses(
								$type,
								array(
									'i' => array(
										'class' => array(),
									),
								)
							);
							?>
						</label>
					</li>
					<?php
					}
					?>
				</ul>
			</div>

			<p class="meta-box__item meta-box__item--external-document-size">
				<label for="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_size">
					<?php esc_html_e( 'Document Size', 'external-links-for-binder' );?>
				</label>
				<br/>
				<input
					type="text"
					id="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_size"
					name="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_size"
					disabled="disabled"
					readonly="readonly"
				/>
			</p>
			<div class="meta-box__item meta-box__item--external-document-url">
				<p>
					<label class="meta-box__label" for="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_url">
						<?php esc_html_e( 'URL', 'external-links-for-binder' );?>
					</label>
					<br/>
					<input
						type="url"
						id="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_url"
						name="<?php echo esc_attr( MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX );?>_url"
						disabled="disabled"
						readonly="readonly"
					/>
				</p>
				<p class="description"><?php esc_html_e( 'The URL of the external document.', 'external-links-for-binder' );?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Save the Expiry Meta
	 *
	 * @param  int $post_id The Post ID.
	 */
	public function mkdo_binder_after_add_entry_save( $post_id ) {

		// If the binder prefix dosnt exit, bail.
		if ( ! defined( 'MKDO_BINDER_PREFIX' ) ) {
			return $post_id;
		}

		// Support for external link.
		if (
			isset( $_POST[ MKDO_BINDER_PREFIX . '_entry_type' ] ) &&
			'external' === $_POST[ MKDO_BINDER_PREFIX . '_entry_type' ] &&
			isset( $_POST[ MKDO_BINDER_PREFIX . '_description' ] ) &&
			! empty( $_POST[ MKDO_BINDER_PREFIX . '_description' ] ) &&
			isset( $_POST[ MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX . '_type' ] ) &&
			isset( $_POST[ MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX . '_url' ] )
		) {
			$description = esc_textarea( $_POST[ MKDO_BINDER_PREFIX . '_description' ] );
			$binder      = new \mkdo\binder\Binder();
			$document    = new \mkdo\binder\Binder_Document();
			$version     = $binder->get_latest_version_by_post_id( $post_id );
			$size        = '0KB';
			$type        = sanitize_text_field( $_POST[ MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX . '_type' ] );
			$url         = esc_url_raw( $_POST[ MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX . '_url' ] );

			if ( isset( $_POST[ MKDO_BINDER_PREFIX . '_version' ] ) ) {
				$version = sanitize_text_field( $_POST[ MKDO_BINDER_PREFIX . '_version' ] );
			}

			if ( isset( $_POST[ MKDO_BINDER_PREFIX . '_version' ] ) ) {
				$size = sanitize_text_field( $_POST[ MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX . '_size' ] );
			}

			$document->post_id     = $post_id;
			$document->upload_date = date( 'Y-m-d H:i:s' );
			$document->user_id     = get_current_user_id();
			$document->type        = esc_attr( $type );
			$document->status      = 'latest';
			$document->version     = esc_html( $version );
			$document->name        = '';
			$document->description = wp_kses_post( $description );
			$document->folder      = '';
			$document->file        = esc_url( $url );
			$document->size        = esc_html( $size );
			$document->thumb       = '';
			$document->mime_type   = '';

			// Update the type.
			wp_set_object_terms( $post_id, array( esc_attr( $type ) ), 'binder_type', false );

			// Add the document.
			\mkdo\binder\Binder::add_entry( $document, $post_id );

			// Stop the item being added again.
			$_POST[ MKDO_BINDER_PREFIX . '_entry_type' ] = null;
		}
	}
}
