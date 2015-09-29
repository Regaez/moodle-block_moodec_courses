<?php
/**
 * Moodec courses block
 *
 * @package    block_moodec_courses
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Moodec courses block
 *
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodec_courses extends block_base {

    /**
     * Block initialization
     */
    public function init() {
        $this->title   = get_string('block_title', 'block_moodec_courses');
    }

    /**
     * Return contents of moodec_courses block
     *
     * @return stdClass contents of block
     */
    public function get_content() {
        global $USER, $CFG, $DB;
        require_once($CFG->dirroot.'/local/moodec/lib.php');

        if($this->content !== NULL) {
            return $this->content;
        }

        // $config = get_config('block_moodec_courses');

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if( !empty($this->config) ) {
            
            // Check config for which courses to select
            if( (int)$this->config->course_selection === 0) {
                // Return latest courses
                $products = local_moodec_get_products(-1, null, 'timecreated', 'DESC');
                $products = array_slice($products, 0, $this->config->courses_shown);
            } elseif( (int)$this->config->course_selection === 1 ) {
                // Return random courses
                $products = local_moodec_get_random_products($this->config->courses_shown);
            } else {
                // TODO: Add return manual courses
                $products = array();
                for($i = 1; $i <= $this->config->courses_shown; $i++) {
                    $manual = 'manual_course_'.$i;
                    $newProduct = local_moodec_get_product((int)$this->config->$manual);
                    if(!!$newProduct) {
                        $products[] = $newProduct;
                    } 
                }
            }

            // Render HTML
            $renderer = $this->page->get_renderer('block_moodec_courses');
            $this->content->text = $renderer->output_products($products, $this->config);        
        }

        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('site-index' => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        return false;
    }
}