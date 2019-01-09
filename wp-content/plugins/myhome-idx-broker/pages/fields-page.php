<div class="wrap">
    <h1>
        <?php esc_html_e( 'Assign MLS Fields', 'myhome-idx-broker' ); ?>
    </h1>
    <div>
        <?php esc_html_e( 'Please import the fields from your MLS by clicking the below button:', 'myhome-idx-broker' ); ?>
    </div>
    <p>
        <a
                class="button button-primary"
                href="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_import_fields' ) ); ?>"
        >
            <?php esc_html_e( 'Import Fields', 'myhome-idx-broker' ); ?>
        </a>
    </p>
    <br><br>
    <div>
        <form
                action="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_save_fields' ) ); ?>"
                method="post"
        >


            <h2><?php esc_html_e( 'Fields Synchronization', 'myhome-idx-broker' ); ?></h2>

            <table class="form-table">
                <?php $myhome_attributes = \MyHomeIDXBroker\Fields::get_attributes(); ?>

                <?php foreach ( \MyHomeIDXBroker\Fields::get() as $myhome_field ) : ?>
                    <tr>
                        <th>
                            <?php echo esc_html( $myhome_field->get_display_name() ); ?>
                        </th>
                        <td>
                            <select
                                    name="fields[<?php echo esc_attr( $myhome_field->get_name() ); ?>][]"
                                    multiple="multiple"
									class="selectize"
                            >
                                <option
                                        value="ignore"
                                    <?php if ( $myhome_field->has_value( 'ignore' ) ) : ?>
                                        selected="selected"
                                    <?php endif; ?>
                                >
                                    <?php esc_html_e( 'Don\'t import', 'myhome-idx-broker' ); ?>
                                </option>
                                <?php foreach ( $myhome_attributes as $myhome_key => $myhome_label ) : ?>
                                    <option
                                            value="<?php echo esc_attr( $myhome_key ); ?>"
                                        <?php if ( $myhome_field->has_value( $myhome_key ) ) : ?>
                                            selected="selected"
                                        <?php endif; ?>
                                    >
                                        <?php echo esc_html( $myhome_label ); ?>
                                    </option>
                                <?php endforeach;; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p>
                <button class="button button-primary">
                    <?php esc_html_e( 'Save', 'myhome-idx-broker' ); ?>
                </button>
            </p>

        </form>
    </div>
</div>

