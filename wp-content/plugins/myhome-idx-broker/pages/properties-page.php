<div class="wrap">
    <h1>
        <?php esc_html_e( 'Synchronize Properties', 'myhome-idx-broker' ); ?>
    </h1>
    <p><?php esc_html_e( 'When you click the "Synchronize" button, MyHome will connect to your MLS and download all available properties to your database', 'myhome-idx-broker' ); ?></p>
    <div id="myhome-idx-broker-import">
        <idx-broker-import></idx-broker-import>
    </div>
    <br><br><br>
    <h2><?php esc_html_e( 'Automatically synchronize via cron jobs (optional)', 'myhome-idx-broker' ); ?></h2>
    <p><?php esc_html_e( 'You can use your server cron jobs to make your properties synchronization fully automatic. You can contact our support team via support@tangibledesign.net if you need help with it.', 'myhome-idx-broker' ); ?></p>
    <p>
        <?php $myhome_idx_broker_hash = \MyHomeIDXBroker\IDX::cron_get_hash(); ?>
        <div><strong><?php esc_html_e( 'Schedule it how often you wish to synchronize e.g. daily at midnight:', 'myhome-idx-broker' ); ?></strong></div>
        <?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_cron_init&myhome_idx_broker_hash=' . $myhome_idx_broker_hash ) ); ?>
        <div><br><strong><?php esc_html_e( 'Schedule it every 60 seconds:', 'myhome-idx-broker' ); ?></strong></div>
        <?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_cron_job&myhome_idx_broker_hash=' . $myhome_idx_broker_hash ) ); ?>
        <br><br>
        <a href="<?php echo esc_url( admin_url( 'admin-post.php?action=myhome_idx_broker_hash' ) ); ?>" class="button button-primary">
            <?php esc_html_e( 'Regenerate hash', 'myhome-idx-broker' ); ?>
        </a>
    </p>
</div>