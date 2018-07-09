<?php

namespace Corcel\Model;

use Corcel\Concerns\AdvancedCustomFields;
use Corcel\Concerns\MetaFields;
use Corcel\Model;

/**
 * Class Term.
 *
 * @package Corcel\Model
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Term extends Model
{
    use MetaFields;
    use AdvancedCustomFields;

    public static function boot()
    {
        parent::boot();

        //while creating/inserting item into db
        static::creating(function ($item) {
            $slug = strtolower(str_replace(' ', '-', $item->name));
            $item->slug = $slug;
        });
    }

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * @var string
     */
    protected $table = 'terms';

    /**
     * @var string
     */
    protected $primaryKey = 'term_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy()
    {
        return $this->hasOne(Taxonomy::class, 'term_id');
    }
}
