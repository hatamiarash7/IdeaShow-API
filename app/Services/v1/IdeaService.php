<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Idea;

class IdeaService
{

    protected $supportedIncludes = [
        'user' => 'user'
    ];

    protected $clauseProperties = [
        'id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getIdeas($parameters)
    {
        if (empty($parameters)) return $this->filterIdeas(Idea::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $ideas = Idea::with($withKeys)->where($whereClauses)->get();

        return $this->filterIdeas($ideas, $withKeys);
    }

    /**
     * @param $request
     * @return bool
     */
    public function createIdea($request)
    {
        $idea = new Idea();

        $idea->user_id = $request->input('user_id');
        $idea->user_name = Idea::where('id', $request->input('user_id'))->firstOrFail()->name;
        $idea->title = $request->input('title');
        $idea->body = $request->input('body');
        if (app('request')->exists('tags')) $idea->tags = $request->input('tags');

        $idea->save();

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateIdea($request, $id)
    {
        $idea = Idea::where('id', $id)->firstOrFail();

        if (app('request')->exists('tags')) $idea->tags = $request->input('tags');

        if (app('request')->exists('like')) $idea->like = $request->input('like');

        if (app('request')->exists('dislike')) $idea->dislike = $request->input('dislike');

        if (app('request')->exists('reported')) $idea->dislike = $request->input('reported');

        $idea->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteIdea($id)
    {
        $idea = Idea::where('id', $id)->firstOrFail();
        $idea->delete();
    }

    /**
     * @param $users
     * @return array
     */
    protected function filterIdeas($ideas, $keys = [])
    {
        $data = [];

        foreach ($ideas as $idea) {
            $entry = [
                'id' => $idea->unique_id,
                'title' => $idea->unique_id,
                'body' => $idea->unique_id,
                'like' => $idea->unique_id,
                'dislike' => $idea->unique_id,
                'tags' => $idea->unique_id,
            ];

            if (in_array('user', $keys))
                $entry['user'] = [
                    'id' => $idea->user_id,
                    'name' => $idea->user_name
                ];

            $data[] = $entry;
        }
        return $data;
    }

    protected function getWithKeys($parameters)
    {
        $withKeys = [];
        if (isset($parameters['include'])) {
            $includeParms = explode(',', $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParms);
            $withKeys = array_keys($includes);
        }
        return $withKeys;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWhereClauses($parameters)
    {
        $clause = [];

        foreach ($this->clauseProperties as $prop)
            if (in_array($prop, array_keys($parameters)))
                $clause[$prop] = $parameters[$prop];

        return $clause;
    }
}