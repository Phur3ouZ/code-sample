<?php

namespace App\Interfaces;

/**
 * @property \App\Models\History\History History
 */
interface IHistory
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function History(): \Illuminate\Database\Eloquent\Relations\HasMany;
}
