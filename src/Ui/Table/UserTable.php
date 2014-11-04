<?php namespace Anomaly\Streams\Addon\Module\Users\Ui\Table;

use Anomaly\Streams\Addon\Module\Users\User\UserModel;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class UserTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\Module\Users\Ui
 */
class UserTable extends Table
{

    /**
     * Set up the table class.
     */
    protected function boot()
    {
        $this->setUpModel();
        $this->setUpViews();
        $this->setUpFilters();
        $this->setUpColumns();
        $this->setUpButtons();
        $this->setUpActions();
    }

    /**
     * Set up the model.
     */
    protected function setUpModel()
    {
        $this
            ->setModel(new UserModel())
            ->setEager(['activation', 'block']);
    }

    /**
     * Set up the table views.
     */
    protected function setUpViews()
    {
        $this->setViews(
            [
                'all',
                [
                    'slug'    => 'active',
                    'title'   => 'module.users::ui.active',
                    'handler' => 'Anomaly\Streams\Addon\Module\Users\Ui\Table\View\ActiveUsersTableView',
                ],
                [
                    'slug'    => 'inactive',
                    'title'   => 'module.users::ui.inactive',
                    'handler' => 'Anomaly\Streams\Addon\Module\Users\Ui\Table\View\InactiveUsersTableView',
                ],
                [
                    'slug'    => 'blocked',
                    'title'   => 'module.users::ui.blocked',
                    'handler' => 'Anomaly\Streams\Addon\Module\Users\Ui\Table\View\BlockedUsersTableView',
                ],
            ]
        );
    }

    /**
     * Set up the table filters.
     */
    protected function setUpFilters()
    {
        $this->setFilters(
            [
                'first_name',
                'email',
            ]
        );
    }

    /**
     * Set up the table columns.
     */
    protected function setUpColumns()
    {
        $this->setColumns(
            [
                [
                    'heading' => 'Name',
                    'value'   => '{first_name} {last_name}',
                ],
                [
                    'heading' => 'module::ui.status',
                    'value'   => function (Table $ui, $entry) {

                            $class = null;
                            $title = null;

                            if (!$entry->activation or !$entry->activation->itIsComplete()) {

                                $class = 'default';
                                $title = 'module::ui.inactive';
                            }

                            if ($entry->activation and $entry->activation->itIsComplete()) {

                                $class = 'success';
                                $title = 'module::ui.active';
                            }

                            if ($entry->block) {

                                $class = 'danger';
                                $title = 'module::ui.blocked';
                            }

                            return '<span class="label label-' . $class . '">' . trans($title) . '</span>';
                        },
                ],
                'username',
                'email.link',
                'last_login_at.valueAndDiffForHumans',
            ]
        );
    }

    /**
     * Set up table buttons.
     */
    protected function setUpButtons()
    {
        $this->setButtons(
            [
                'edit',
            ]
        );
    }

    /**
     * Set up the table actions.
     */
    protected function setUpActions()
    {
        $this->setActions(
            [
                [
                    'type'    => 'success',
                    'slug'    => 'activate',
                    'title'   => 'module.users::button.activate',
                    'handler' => 'Anomaly\Streams\Addon\Module\Users\Ui\Table\Action\ActivateUsersTableAction',
                    'enabled' => function (Table $ui) {

                            $view = app('request')->get($ui->getPrefix() . 'view', 'all');

                            return ($view == 'all');
                        }
                ],
                [
                    'type'    => 'delete',
                    'icon'    => 'fa fa-trash',
                    'slug'    => 'delete',
                    'title'   => 'button.delete',
                    'handler' => 'Anomaly\Streams\Addon\Module\Users\Ui\Table\Action\DeleteUsersTableAction',
                    'enabled' => function (Table $ui) {

                            $view = app('request')->get($ui->getPrefix() . 'view', 'all');

                            return ($view == 'all');
                        }
                ],
            ]
        );
    }
}
 