<?php
add_filter('pre_set_site_transient_update_themes', 'check_for_theme_update');

function check_for_theme_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $theme_data = wp_remote_get('https://raw.githubusercontent.com/craigcallen/iprosystems.com/main/update-check.php');
    $theme_data = json_decode($theme_data['body']);

    $remote_version = $theme_data->version;

    if (version_compare($transient->checked['iprosystems/style.css'], $remote_version, '<')) {
        $transient->response['iprosystems/style.css'] = array(
            'theme'       => 'iprosytems',
            'new_version' => $remote_version,
            'url'         => $theme_data->url,
        );
    }

    return $transient;
}

add_filter('upgrader_pre_install', 'install_custom_theme', 10, 3);

function install_custom_theme($true, $hook_extra, $result) {
    global $wp_filesystem;

    $config = array(
        'timeout' => 60, // Set a timeout for the request
        'headers' => array(
            'Authorization' => 'Bearer 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', // Optional: Use a token if your repo is private
        ),
    );

    $download_url = $result['package'];

    $downloaded_theme = wp_remote_get($download_url, $config);

    $wp_filesystem->put_contents(WP_CONTENT_DIR . '/themes/iprosytems.zip', $downloaded_theme['body'], FS_CHMOD_FILE);

    return $result;
}
