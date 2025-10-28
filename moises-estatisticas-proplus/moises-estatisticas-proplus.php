<?php
/*
Plugin Name: Estatísticas Moisés Dev Pro+
Description: Estatísticas dinâmicas de acessos, músicas, vídeos e acervos (incluindo Tainacan e documentos) com bloco Gutenberg e shortcode.
Version: 3.0
Author: Moisés Dev Pro+
License: GPL2
*/

if (!defined('ABSPATH')) exit;

// CONTAGEM DINÂMICA DE CONTEÚDOS
function mdp_get_counts_db() {
    global $wpdb;

    $audios = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type IN ('audio','musica') AND post_status='publish'");
    $mp3s  = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'audio/%'");

    $videos = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='video' AND post_status='publish'");
    $videos_mp4 = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type LIKE 'video/%'");

    $tainacan_items = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type IN ('tainacan-collection','tainacan-item') AND post_status='publish'");

    $documentos = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_mime_type IN (
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.oasis.opendocument.text'
    )");

    return [
        'audios'  => (int)$audios + (int)$mp3s,
        'videos'  => (int)$videos + (int)$videos_mp4,
        'acervos' => (int)$tainacan_items + (int)$documentos
    ];
}

// CONTAGEM DE ACESSOS
function mdp_contar_acessos() {
    $semana = date('o-W');
    $acessos = get_option('mdp_acessos', []);
    $ip = $_SERVER['REMOTE_ADDR'];

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $user_acessos = get_user_meta($user_id, 'mdp_acessos', true) ?: [];
        if (!isset($user_acessos[$semana])) $user_acessos[$semana] = 0;
        $user_acessos[$semana]++;
        update_user_meta($user_id, 'mdp_acessos', $user_acessos);
    } else {
        if (!isset($acessos['visitantes'][$ip][$semana])) $acessos['visitantes'][$ip][$semana] = 0;
        $acessos['visitantes'][$ip][$semana]++;
    }

    update_option('mdp_acessos', $acessos);
}
add_action('wp', 'mdp_contar_acessos');

// RENDERIZAÇÃO
function mdp_render_estatisticas() {
    $counts = mdp_get_counts_db();
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_id = get_current_user_id();
    $semana = date('o-W');

    if ($user_id) {
        $user_acessos = get_user_meta($user_id, 'mdp_acessos', true) ?: [];
        $visitas = isset($user_acessos[$semana]) ? $user_acessos[$semana] : 0;
    } else {
        $acessos = get_option('mdp_acessos', []);
        $visitas = isset($acessos['visitantes'][$ip][$semana]) ? $acessos['visitantes'][$ip][$semana] : 0;
    }

    ob_start(); ?>
    <div class="mdp-container">
        <h3>📊 Estatísticas do Site</h3>
        <div class="mdp-linha">
            <div class="mdp-item"><strong>Acessos:</strong> <?php echo number_format($visitas,0,',','.'); ?></div>
            <div class="mdp-item"><strong>Vídeos:</strong> <?php echo number_format($counts['videos'],0,',','.'); ?></div>
        </div>
        <div class="mdp-linha">
            <div class="mdp-item"><strong>Acervos:</strong> <?php echo number_format($counts['acervos'],0,',','.'); ?></div>
            <div class="mdp-item"><strong>Músicas:</strong> <?php echo number_format($counts['audios'],0,',','.'); ?></div>
        </div>
        <p class="mdp-creditos">💡 Plugin desenvolvido por <strong>Moisés Dev Pro+</strong></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('estatisticas_site', 'mdp_render_estatisticas');

// BLOCO GUTENBERG
function mdp_register_block() {
    register_block_type('moises/estatisticas-proplus', [
        'render_callback' => 'mdp_render_estatisticas',
        'api_version' => 2,
        'title' => 'Estatísticas Moisés Dev Pro+',
        'icon' => 'chart-bar',
        'category' => 'widgets'
    ]);
}
add_action('init', 'mdp_register_block');

// ESTILO
add_action('wp_enqueue_scripts', function() {
    wp_register_style('mdp-style', false);
    wp_enqueue_style('mdp-style');
    $custom_css = "
        .mdp-container {
            background: #f8f8f8;
            border-radius: 12px;
            padding: 20px;
            max-width: 480px;
            margin: 20px auto;
            text-align: left;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .mdp-container h3 {
            color: #30b36a;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }
        .mdp-linha {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .mdp-item { font-size: 15px; }
        .mdp-creditos {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-top: 12px;
        }
    ";
    wp_add_inline_style('mdp-style', $custom_css);
});
?>
