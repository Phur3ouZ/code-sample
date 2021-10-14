<?php

namespace App\Interfaces;

/**
 * @property \App\Models\History\History History
 */
interface HasHistory
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function History(): \Illuminate\Database\Eloquent\Relations\HasMany;
}
