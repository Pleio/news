<?php
class ElggNews extends ElggObject {
    const SUBTYPE = 'news';

    protected function initializeAttributes() {
        parent::initializeAttributes();
        $this->attributes['subtype'] = self::SUBTYPE;
    }

    public function getURL() {
        return '/news/view/' . $this->guid . '/' . elgg_get_friendly_title($this->title) . '/';
    }

    public function getHeaderURL() {
        if ($this->headertime) {
            return '/news/header/' . $this->guid . '.jpg?time=' . $this->headertime;
        }
    }
}