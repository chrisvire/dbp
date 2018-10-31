<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ArclightTransformer extends BaseTransformer
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
	public function transform($arclight)
	{
		switch ($this->version) {
			case 2:
			case 3: return $this->transformForV2($arclight);
			case 4:
			default: return $this->transformForV4($arclight);
		}
	}

	public function transformForV2($arclight)
	{
		$id = (int) substr($arclight->mediaComponentId,6,2);
		switch ($this->route) {
			case 'v2_api_jesusFilm_index': {
				return [
					'id'                   => (string) $id,
                    'name'                 => (string) $arclight->title,
                    'filename'             => $arclight->file_name,
                    'arclight_ref_id'      => (string) $arclight->mediaComponentId,
                    'arclight_language_id' => (string) $arclight->lengthInMilliseconds,
                    'arclight_boxart_urls' => [
                        [ 'url' => [ 'type' => 'Mobile Cinematic Low', 'uri' => $arclight->imageUrls->mobileCinematicLow ] ],
                        [ 'url' => [ 'type' => 'Mobile Cinematic High', 'uri' => $arclight->imageUrls->mobileCinematicHigh ] ]
                    ],
					'verses' => collect($arclight->bibleCitations)->mapWithKeys(function ($item) {
						return [$item->osisBibleBook => [ $item->chapterStart => [ (string) $item->verseStart ]]];
					})
				];
			}

		}
	}

	public function transformForV4()
	{

	}


}