<?php
/**
 * Form for editing Moodec course instances.
 *
 * @copyright 2015 Thomas Threadgold, LearningWorks Ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodec_courses_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $CFG, $PAGE;
        require_once($CFG->dirroot.'/local/moodec/lib.php');

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Add number of courses to display selection
        $mform->addElement(
            'select',
            'config_courses_shown',
            get_string(
                'courses_shown', 
                'block_moodec_courses'
            ),
            array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
            )
        );
        $mform->setType('config_courses_shown', PARAM_INT);

        // Add show image checkbox
        $mform->addElement(
            'advcheckbox',
            'config_show_image',
            get_string(
                'show_image',
                'block_moodec_courses'
            ),
            get_string(
                'show_image_label',
                'block_moodec_courses'
            )
        );
        $mform->setType('config_show_image', PARAM_INT);

        // Add show description checkbox
        $mform->addElement(
            'advcheckbox',
            'config_show_description',
            get_string(
                'show_description',
                'block_moodec_courses'
            ),
            get_string(
                'show_description_label',
                'block_moodec_courses'
            )
        );
        $mform->setType('config_show_description', PARAM_INT);


        // Add show price checkbox
        $mform->addElement(
            'advcheckbox',
            'config_show_price',
            get_string(
                'show_price',
                'block_moodec_courses'
            ),
            get_string(
                'show_price_label',
                'block_moodec_courses'
            )
        );
        $mform->setType('config_show_price', PARAM_INT);


        // Add display method selection
        $mform->addElement(
            'select',
            'config_course_selection',
            get_string(
                'course_selection', 
                'block_moodec_courses'
            ),
            array(
                0 => get_string('select_latest_courses', 'block_moodec_courses'),
                1 => get_string('select_random_courses', 'block_moodec_courses'),
                2 => get_string('select_manual_courses', 'block_moodec_courses')
            )
        );
        $mform->setType('config_course_selection', PARAM_INT);

        // Get all products and store in an array of ID and fullname
        $products = local_moodec_get_products(-1, null,'fullname', 'ASC');
        $allProducts = array();

        foreach ($products as $p) {
            $allProducts[$p->get_id()] = $p->get_fullname();
        }

        // Add manual course selection 1
        $mform->addElement(
            'select',
            'config_manual_course_1',
            get_string(
                'manual_course_selection', 
                'block_moodec_courses',
                array(
                    'id' => 1
                )
            ),
            $allProducts
        );
        $mform->setType('config_manual_course_1', PARAM_INT);
        $mform->disabledif('config_manual_course_1', 'config_course_selection', 'neq', 2);

        // Add manual course selection 2
        $mform->addElement(
            'select',
            'config_manual_course_2',
            get_string(
                'manual_course_selection', 
                'block_moodec_courses',
                array(
                    'id' => 2
                )
            ),
            $allProducts
        );
        $mform->setType('config_manual_course_2', PARAM_INT);
        $mform->disabledif('config_manual_course_2', 'config_course_selection', 'neq', 2);
        $mform->disabledif('config_manual_course_2', 'config_courses_shown', 'eq', 1);



        // Add manual course selection 3
        $mform->addElement(
            'select',
            'config_manual_course_3',
            get_string(
                'manual_course_selection', 
                'block_moodec_courses',
                array(
                    'id' => 3
                )
            ),
            $allProducts
        );
        $mform->setType('config_manual_course_3', PARAM_INT);
        $mform->disabledif('config_manual_course_3', 'config_course_selection', 'neq', 2);
        $mform->disabledif('config_manual_course_3', 'config_courses_shown', 'eq', 1);
        $mform->disabledif('config_manual_course_3', 'config_courses_shown', 'eq', 2);


        // Add manual course selection 4
        $mform->addElement(
            'select',
            'config_manual_course_4',
            get_string(
                'manual_course_selection', 
                'block_moodec_courses',
                array(
                    'id' => 4
                )
            ),
            $allProducts
        );
        $mform->setType('config_manual_course_4', PARAM_INT);
        $mform->disabledif('config_manual_course_4', 'config_course_selection', 'neq', 2);
        $mform->disabledif('config_manual_course_4', 'config_courses_shown', 'eq', 1);
        $mform->disabledif('config_manual_course_4', 'config_courses_shown', 'eq', 2);
        $mform->disabledif('config_manual_course_4', 'config_courses_shown', 'eq', 3);

        $PAGE->requires->jquery();
        $PAGE->requires->js(new moodle_url($CFG->wwwroot .'/blocks/moodec_courses/edit_form.js'));

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {
            $defaults->config_courses_shown     = (int) $this->block->config->courses_shown;
            $defaults->config_show_price        = !!$this->block->config->show_price;
            $defaults->config_show_image        = !!$this->block->config->show_image;
            $defaults->config_show_description  = !!$this->block->config->show_description;
            $defaults->config_course_selection  = (int) $this->block->config->course_selection;

            if( $defaults->config_course_selection  === 2 ) {
                $defaults->config_manual_course_1   = (int) $this->block->config->manual_course_1;
                
                if( 1 < $defaults->config_courses_shown ) {
                    $defaults->config_manual_course_2   = (int) $this->block->config->manual_course_2;
                }
                
                if( 2 < $defaults->config_courses_shown ) {
                    $defaults->config_manual_course_3   = (int) $this->block->config->manual_course_3;
                }
                
                if( 3 < $defaults->config_courses_shown ) {
                    $defaults->config_manual_course_4   = (int) $this->block->config->manual_course_4;
                }
            }
        }

       parent::set_data($defaults);
    }
}