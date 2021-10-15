<?php

namespace App\Http\Repositories;

use App\Interfaces\IRepository;

class Repository implements IRepository
{
    /**
     * @param  string  $action
     * @return array
     */
    public function getRules(string $action = 'none'): array
    {
        $rules = $this->getRuleTypes();

        switch ($action) {
            case 'create':
                $rules = array_merge_recursive(
                    $rules,
                    array_fill_keys($this->getRuleRequirementsCreate(), ['required'])
                );
                break;
            case 'edit':
                $rules = array_merge_recursive(
                    $rules,
                    array_fill_keys($this->getRuleRequirementsEdit(), ['required'])
                );
                break;
            default:
                break;
        }

        return $rules;
    }


    /**
     * @return array
     */
    protected function getRuleTypes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getRuleRequirementsCreate(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getRuleRequirementsEdit(): array
    {
        return [];
    }
}
