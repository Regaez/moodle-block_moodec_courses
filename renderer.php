<?php
/**
 * moodec_courses block rendrer
 *
 * @package    block_moodec_courses
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

/**
 * moodec_courses block renderer
 *
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodec_courses_renderer extends plugin_renderer_base {

    /**
     * Construct contents of moodec_courses block
     *
     * @param   array   $products    The list of products to be output
     * @return  string              html to be displayed in moodec_courses block
     */
    public function output_products($products, $config) {
        global $CFG;
        require_once($CFG->dirroot.'/local/moodec/lib.php');

        $html = '';

        $count = count($products);
        
        $html .= sprintf(
            '<div class="product-list list--%d">',
            $count
        );

        foreach ($products as $p) {

            $html .= '<div class="product-item">';

                // Output image
                if((bool)$config->show_image) {
                    $imageURL = $p->get_image_url();

                    if(!!$imageURL) {
                        $html .= sprintf(
                            '<img class="product-image" src="%s" alt="%s">',
                            $imageURL,
                            $p->get_fullname()
                        );
                    }
                }

                // Output title
                $html .= sprintf(
                    '<h4 class="product-title">%s</h4>',
                    $p->get_fullname()
                );

                // Output description
                if((bool)$config->show_description) {
                    $html .= sprintf(
                        '<div class="product-description">%s</div>',
                        substr($p->get_summary(), 0, 100) . '...'
                    );
                }

                // Output price
                if((bool)$config->show_price) {
                    if( $p->get_type() === PRODUCT_TYPE_SIMPLE) {
                        // Output simple price
                        $html .= sprintf(
                            '<h5 class="product-price">$%s</h5>',
                            $p->get_price()
                        );
                    } else {
                        // Get min and max variation prices
                        $priceArray = array();

                        foreach ($p->get_variations() as $v) {
                            $priceArray[] = $v->get_price();
                        }

                        $minPrice = min($priceArray);
                        $maxPrice = max($priceArray);

                        // Output variation price
                        $html .= sprintf(
                            '<h5 class="product-price">$%s - $%s</h5>',
                            $minPrice,
                            $maxPrice
                        );
                    }
                }

                // Output link to product
                $html .= sprintf(
                    '<a href="%s" class="product-link btn">%s</a>',
                    new moodle_url(
                        $CFG->wwwroot.'/local/moodec/pages/product.php',
                        array(
                            'id'=> $p->get_id()
                        )
                    ),
                    get_string('product_link', 'block_moodec_courses')
                );

            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }
}