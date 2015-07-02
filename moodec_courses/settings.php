<?php
/**
 * moodec_courses block settings
 *
 * @package    block_moodec_courses
 * @copyright  2015 Thomas Threadgold, LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    
    $settings->add(
        new admin_setting_configselect(
            'block_moodec_courses/courses_shown', 
            get_string(
                'courses_shown', 
                'block_moodec_courses'
            ),
            get_string(
                'courses_shown_desc',
                'block_moodec_courses'
            ),
            3,
            array(
                1,
                2,
                3,
                4,
            )
        )
    );
    
    $settings->add(
        new admin_setting_configcheckbox(
            'block_moodec_courses/show_description', 
            get_string(
                'show_description',
                'block_moodec_courses'
            ),
            get_string(
                'show_description_desc',
                'block_moodec_courses'
            ),
            1,
            PARAM_INT
        )
    );

    $settings->add(
        new admin_setting_configcheckbox(
            'block_moodec_courses/show_price', 
            get_string(
                'show_price',
                'block_moodec_courses'
            ),
            get_string(
                'show_price_desc',
                'block_moodec_courses'
            ),
            1,
            PARAM_INT
        )
    );

    $settings->add(
        new admin_setting_configselect(
            'block_moodec_courses/course_selection', 
            get_string(
                'course_selection', 
                'block_moodec_courses'
            ),
            get_string(
                'course_selection_desc',
                'block_moodec_courses'
            ),
            get_string('select_latest_courses', 'block_moodec_courses'),
            array(
                0 => get_string('select_latest_courses', 'block_moodec_courses'),
                1 => get_string('select_random_courses', 'block_moodec_courses'),
                2 => get_string('select_manual_courses', 'block_moodec_courses')
            )
        )
    );

}
