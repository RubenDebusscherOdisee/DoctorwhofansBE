<?php

namespace heinrichk\searchreload\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
	}

	
    /**
     * Assign functions defined in this class to event listeners in the core
     *
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            'core.search_results_modify_search_title' => 'reload_page',
        );
    }

    /**
     * Load the Acme Demo language file
     *     acme/demo/language/en/demo.php
     *
     * @param \phpbb\event\data $event The event object
     */
    public function reload_page($event)
    {
		switch($this->request->variable('search_id', '')) {
			case 'egosearch':
			case 'newposts':
			case 'unreadposts':
			case 'unanswered':
			case 'active_topics':
				header("Refresh:120");
		}

    }
}