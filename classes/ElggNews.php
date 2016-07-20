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

    public function getTopPhotoURL() {
        if ($this->topPhotoTime) {
            return '/news/photo/' . $this->guid . '.jpg?type=top_photo&time=' . $this->topPhotoTime;
        }
    }

    public function getFeaturedPhotoURL() {
        if ($this->featuredPhotoTime) {
            return '/news/photo/' . $this->guid . '.jpg?type=featured_photo&time=' . $this->featuredPhotoTime;
        }
    }
}