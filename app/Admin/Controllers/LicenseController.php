<?php

namespace App\Admin\Controllers;

use App\Model\LicenseModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class LicenseController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new licenseModel);

        $grid->company_id('Company id');
        $grid->enterprise_name('Enterprise name');
        $grid->corporate_name('Corporate name');
        $grid->banck_account('Banck account');
        $grid->license('License')->display(function($img){
            return '<img src="/'.$img.'" width="60" high="60" >' ;
        });
        $grid->appid('Appid');
        $grid->key('Key');
        $grid->access_token('Access token');
//        $grid->company_status('Company status');
        $states = [
            'on'  => ['value' => 1, 'text' => '关闭', 'color' => 'danger'],
            'off' => ['value' => 2, 'text' => '打开', 'color' => 'success'],
        ];
        $grid->company_status('审核状态')->switch($states);
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(licenseModel::findOrFail($id));

        $show->company_id('Company id');
        $show->enterprise_name('Enterprise name');
        $show->corporate_name('Corporate name');
        $show->banck_account('Banck account');
        $show->license('License');
        $show->appid('Appid');
        $show->key('Key');
        $show->access_token('Access token');
        $show->company_status('Company status');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new licenseModel);

        $form->number('company_id', 'Company id');
        $form->text('enterprise_name', 'Enterprise name');
        $form->text('corporate_name', 'Corporate name');
        $form->text('banck_account', 'Banck account');
        $form->text('license', 'License');
        $form->text('appid', 'Appid');
        $form->text('key', 'Key');
        $form->text('access_token', 'Access token');
//        $form->switch('company_status', 'Company status')->default('1');
        $states = [
            'on'  => ['value' => 1, 'text' => '关闭', 'color' => 'danger'],
            'off' => ['value' => 2, 'text' => '打开', 'color' => 'success'],
        ];
        $form->switch('company_status','审核状态')->switch($states);
        return $form;
    }

    public function update($id,Request $request)
    {
        $company_status = $request->input('company_status');
        if ($company_status=='on'){
            $status = 1;
            LicenseModel::where(['company_id'=>$id])->update(['company_status'=>$status]);
        }else{
            $status = 2;
            LicenseModel::where(['company_id'=>$id])->update(['company_status'=>$status]);
        }

    }
}
