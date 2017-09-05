<?php

namespace App\Pagination;

class SelectPaginationView extends PaginationView
{
    /**
     * @var string
     */
    private $prev_text = '<i class="fa fa-angle-left"></i>';

    /**
     * @var string
     */
    private $next_text = '<i class="fa fa-angle-right"></i>';

    /**
     * Get pagination html.
     *
     * @return string
     */
    public function html()
    {
        $out  = '<form class="ssd-pagination">';
        $out .= $this->previousHtml();
        $out .= $this->pageLabel();
        $out .= $this->currentHtml();
        $out .= $this->ofLabel();
        $out .= $this->nextHtml();
        $out .= '</form>';

        return $out;
    }

    /**
     * Get previous button.
     *
     * @return string
     */
    private function previousHtml()
    {
        if ($this->pagination->isFirstPage()) {
            return $this->inactivePreviousHtml();
        }

        $format = '<a href="%s" class="button">' . $this->prev_text . '</a>';

        return sprintf(
            $format,
            $this->pagination->previousUrl()
        );
    }

    /**
     * Get previous disabled button.
     *
     * @return string
     */
    private function inactivePreviousHtml()
    {
        return '<span class="button disabled">' . $this->prev_text . '</span>';
    }

    /**
     * Get 'Page' label.
     *
     * @return string
     */
    private function pageLabel()
    {
        return '<span class="label">Page</span>';
    }

    /**
     * Get 'of ?' label.
     *
     * @return string
     */
    private function ofLabel()
    {
        return '<span class="label">of ' . $this->pagination->numberOfPages() . '</span>';
    }

    /**
     * Get current html string.
     *
     * @return string
     */
    private function currentHtml()
    {
        $out  = '<select>';
        $out .= $this->options();
        $out .= '</select>';

        return $out;
    }

    /**
     * Get all select options.
     *
     * @return string
     */
    private function options()
    {
        $options = [];

        foreach(range(1, $this->pagination->numberOfPages()) as $page) {
            $options[] = $this->option($page);
        }

        return implode($options);
    }

    /**
     * Get a single option.
     *
     * @param int $page
     * @return string
     */
    private function option($page)
    {
        $option  = '<option value="';
        $option .= $this->optionValue($page);
        $option .= '"';
        $option .= $this->selected($page);
        $option .= '>';
        $option .= $page;
        $option .= '</option>';

        return $option;
    }

    /**
     * Get option value.
     *
     * @param int $page
     * @return string
     */
    private function optionValue($page)
    {
        return $this->pagination->url($page);
    }

    /**
     * Get selected attribute.
     *
     * @param int $page
     * @return string
     */
    private function selected($page)
    {
        if ( ! $this->pagination->isCurrentPage($page)) {
            return '';
        }

        return ' selected="selected"';
    }

    /**
     * Get next button.
     *
     * @return string
     */
    private function nextHtml()
    {
        if ($this->pagination->isLastPage()) {
            return $this->inactiveNextHtml();
        }

        $format = '<a href="%s" class="button">' . $this->next_text . '</a>';

        return sprintf(
            $format,
            $this->pagination->nextUrl()
        );
    }

    /**
     * Get next disabled button.
     *
     * @return string
     */
    private function inactiveNextHtml()
    {
        return '<span class="button disabled">' . $this->next_text . '</span>';
    }
}