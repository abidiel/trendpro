<?php
/**
 * Template Name: Just Play - Redirecionamento Temporário
 * Slug: justplay
 * 
 * Redireciona para home até o conteúdo estar pronto
 */

// Redirecionamento 302 (temporário)
wp_redirect(home_url('/'), 302);
exit();
?>