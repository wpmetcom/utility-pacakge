<?php
namespace Wpmet\UtilityPackage\Helper;

defined('ABSPATH') || exit;
/**
 * package helper class.
 *
 * @since 1.0.0
 */

class Helper
{
   
    public static function kses($raw)
    {

        $allowed_tags = array(
            'a'                             => array(
                'class'  => array(),
                'href'   => array(),
                'rel'    => array(),
                'title'  => array(),
                'target' => array(),
            ),
            'abbr'                          => array(
                'title' => array(),
            ),
            'b'                             => array(),
            'blockquote'                    => array(
                'cite' => array(),
            ),
            'cite'                          => array(
                'title' => array(),
            ),
            'code'                          => array(),
            'del'                           => array(
                'datetime' => array(),
                'title'    => array(),
            ),
            'dd'                            => array(),
            'div'                           => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'dl'                            => array(),
            'dt'                            => array(),
            'em'                            => array(),
            'h1'                            => array(
                'class' => array(),
            ),
            'h2'                            => array(
                'class' => array(),
            ),
            'h3'                            => array(
                'class' => array(),
            ),
            'h4'                            => array(
                'class' => array(),
            ),
            'h5'                            => array(
                'class' => array(),
            ),
            'h6'                            => array(
                'class' => array(),
            ),
            'i'                             => array(
                'class' => array(),
            ),
            'img'                           => array(
                'alt'    => array(),
                'class'  => array(),
                'height' => array(),
                'src'    => array(),
                'width'  => array(),
            ),
            'li'                            => array(
                'class' => array(),
            ),
            'ol'                            => array(
                'class' => array(),
            ),
            'p'                             => array(
                'class' => array(),
            ),
            'q'                             => array(
                'cite'  => array(),
                'title' => array(),
            ),
            'span'                          => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'iframe'                        => array(
                'width'       => array(),
                'height'      => array(),
                'scrolling'   => array(),
                'frameborder' => array(),
                'allow'       => array(),
                'src'         => array(),
            ),
            'strike'                        => array(),
            'br'                            => array(),
            'strong'                        => array(),
            'data-wow-duration'             => array(),
            'data-wow-delay'                => array(),
            'data-wallpaper-options'        => array(),
            'data-stellar-background-ratio' => array(),
            'ul'                            => array(
                'class' => array(),
            ),
        );

        if (function_exists('wp_kses')) {
            // WP is here
            return wp_kses($raw, $allowed_tags);
        } else {
            return $raw;
        }
    }
    public static function get_kses_array()
    {

        $allowed_tags = array(
            'a'                             => array(
                'class'  => array(),
                'href'   => array(),
                'rel'    => array(),
                'title'  => array(),
                'target' => array(),
            ),
            'abbr'                          => array(
                'title' => array(),
            ),
            'b'                             => array(),
            'blockquote'                    => array(
                'cite' => array(),
            ),
            'cite'                          => array(
                'title' => array(),
            ),
            'code'                          => array(),
            'del'                           => array(
                'datetime' => array(),
                'title'    => array(),
            ),
            'dd'                            => array(),
            'div'                           => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'dl'                            => array(),
            'dt'                            => array(),
            'em'                            => array(),
            'h1'                            => array(
                'class' => array(),
            ),
            'h2'                            => array(
                'class' => array(),
            ),
            'h3'                            => array(
                'class' => array(),
            ),
            'h4'                            => array(
                'class' => array(),
            ),
            'h5'                            => array(
                'class' => array(),
            ),
            'h6'                            => array(
                'class' => array(),
            ),
            'i'                             => array(
                'class' => array(),
            ),
            'img'                           => array(
                'alt'    => array(),
                'class'  => array(),
                'height' => array(),
                'src'    => array(),
                'width'  => array(),
            ),
            'li'                            => array(
                'class' => array(),
            ),
            'ol'                            => array(
                'class' => array(),
            ),
            'p'                             => array(
                'class' => array(),
            ),
            'q'                             => array(
                'cite'  => array(),
                'title' => array(),
            ),
            'span'                          => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'iframe'                        => array(
                'width'       => array(),
                'height'      => array(),
                'scrolling'   => array(),
                'frameborder' => array(),
                'allow'       => array(),
                'src'         => array(),
            ),
            'strike'                        => array(),
            'br'                            => array(),
            'strong'                        => array(),
            'data-wow-duration'             => array(),
            'data-wow-delay'                => array(),
            'data-wallpaper-options'        => array(),
            'data-stellar-background-ratio' => array(),
            'ul'                            => array(
                'class' => array(),
            ),
        );

        return $allowed_tags;
    }

    public static function get_pac_version(){
        return \Composer\InstalledVersions::getPrettyVersion('wpmet/utility-package');
    }

}
