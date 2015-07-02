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
    public function output_products($products) {
        global $CFG;
        require_once($CFG->dirroot.'/local/moodec/lib.php');

        $html = '';
        $config = get_config('block_moodec_courses');

        $count = count($products);
        
        $html .= sprintf(
            '<div class="product-list list--%d">',
            $count
        );

        foreach ($products as $p) {

            $html .= '<div class="product-item">';

                // Output image
                $html .= sprintf(
                    '<img class="product-image" src="%s" alt="%s">',
                    local_moodec_get_course_image_url($p->courseid),
                    $p->fullname
                );

                // Output title
                $html .= sprintf(
                    '<h3 class="product-title">%s</h3>',
                    $p->fullname
                );

                // Output description
                $html .= sprintf(
                    '<div class="product-description">%s</div>',
                    substr($p->summary, 0, 100) . '...'
                );

                // Output price
                $html .= sprintf(
                    '<h4 class="product-price">%s</h4>',
                    $p->price
                );

                // Output link to product
                $html .= sprintf(
                    '<a href="%s" class="product-link">%s</a>',
                    new moodle_url(
                        $CFG->wwwroot.'/local/moodec/pages/product.php',
                        array(
                            'id'=> $p->id
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