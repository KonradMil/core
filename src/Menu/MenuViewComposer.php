<?php

namespace Chatter\Core\Menu;

use Illuminate\View\View;
use Chatter\Core\Models\Category;

class MenuViewComposer
{
    protected $menuProvider;

    public function __construct(MenuProviderInterface $menuProvider)
    {
        $this->menuProvider = $menuProvider;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $parentCategories = Category::where('parent_id', '=', NULL)->get();
        foreach ($parentCategories as $pc) {
            $children = Category::where('parent_id', '=', $pc->id)->get();
            $pc->children_categories = $children;
        }
        $view->with('categories', $parentCategories);

        $view->with('menu', $this->menuProvider->get());
    }
}
