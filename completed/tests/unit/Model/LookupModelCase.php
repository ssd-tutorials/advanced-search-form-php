<?php


abstract class LookupModelCase extends ModelCase
{
    use ModelData;

    /**
     * Get instance of a given model.
     *
     * @return \App\Model\Model
     */
    abstract protected function modelInstance();

    /**
     * @test
     */
    public function can_create_and_return_collection_of_models()
    {
        $model = $this->modelInstance();

        $model->create($this->lookupData(['name' => 'Name 1']));
        $model->create($this->lookupData(['name' => 'Name 2']));
        $model->create($this->lookupData(['name' => 'Name 3']));

        $models = $model->all();

        $this->assertEquals(
            'Name 1',
            $models[0]->name,
            'Model name does not match Name 1'
        );

        $this->assertEquals(
            'Name 2',
            $models[1]->name,
            'Model name does not match Name 2'
        );

        $this->assertEquals(
            'Name 3',
            $models[2]->name,
            'Model name does not match Name 3'
        );
    }

    /**
     * @test
     */
    public function can_update_model()
    {
        $modelInstance = $this->modelInstance();

        $model = $modelInstance->create(
            $this->lookupData(['name' => 'Name 1'])
        );

        $this->assertEquals(
            'Name 1',
            $model->name,
            'Could not create model with name Name 1'
        );

        $model = $modelInstance->update(
            ['name' => 'Name 2'],
            $model->id
        );

        $this->assertEquals(
            'Name 2',
            $model->name,
            'Could not update model with name Name 2'
        );
    }

    /**
     * @test
     */
    public function can_remove_model()
    {
        $modelInstance = $this->modelInstance();

        $model = $modelInstance->create($this->lookupData());

        $this->assertCount(
            1,
            $model->all(),
            'Number of model records does not match 1'
        );

        $model->delete($model->id);

        $this->assertCount(
            0,
            $model->all(),
            'Number of model records does not match 0'
        );
    }

    /**
     * @test
     */
    public function can_call_all_records_method_dynamically()
    {
        $model = $this->modelInstance();

        $model->create($this->lookupData());
        $model->create($this->lookupData());
        $model->create($this->lookupData());

        $this->assertCount(
            3,
            $model->{$model->getTableName()}(),
            'Dynamic method call failed'
        );
    }
}
















