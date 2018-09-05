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
            $slug = self::slugify($item->name);
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

    /**
     * Slugify the text
     *
     * @param $text
     * @return null|string|string[]
     */
    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
