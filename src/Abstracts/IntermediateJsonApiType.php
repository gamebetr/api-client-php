<?php

declare(strict_types=1);

namespace Gamebetr\ApiClient\Abstracts;

use Gamebetr\ApiClient\Utility\Type;

/**
 * Simple JSONAPI bridge for Gamebetr types.
 */
abstract class IntermediateJsonApiType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    protected function parseRelationships(object $data): void
    {
        if (isset($data->relationships, $data->included)) {
            // Strip out relations that don't have a data property because
            // these are not valid JSONAPI.
            $original_relationships = array_filter((array)$data->relationships, static function ($item) {
                return !empty($item->data);
            });

            // Convert singular relationships to collections just for
            // consistency and ease of use.
            $original_relationships = array_map(static function ($item) {
                return is_array($item->data) ? $item->data : [$item->data];
            }, $original_relationships);

            $this->setRelationsFromIncludes($original_relationships, $data->included);
        }
    }

    /**
     * Sets this Type's relationship array based on include data.
     *
     * @param array $relationGroups
     *  Relation type/id pairs as returned on a JSONAPI document.
     * @param array $includedRelations
     *  The included array from the JSONAPI response.
     */
    protected function setRelationsFromIncludes(array $relationGroups, array $includedRelations): void
    {
        foreach ($relationGroups as $groupName => $relations) {
            // Filter out invalid relationship entries that are missing
            // required properties for mapping to includes.
            $relations = array_filter($relations, static function ($item) {
                return !empty($item->type) && !empty($item->id);
            });

            // Map our relationship data to items that were included in the
            // request.
            $relations = array_map(function ($item) use ($includedRelations) {
                return $this->getMatchingDocument($includedRelations, $item->type, $item->id);
            }, $relations);

            // Filter out relationships that did not map to anything.
            $relations = array_filter($relations);

            $this->relationships[$groupName] = Type::make($relations);
        }
    }

    /**
     * Get matching document information.
     *
     * @param array $documents
     *   The document (includes) array.
     * @param string $type
     *   The type of document to get.
     * @param string $uuid
     *   The uuid of the document to get.
     *
     * @return object|null
     *   The document that was matched, or null.
     */
    protected function getMatchingDocument(array $documents, string $type, string $uuid): ?object
    {
        foreach ($documents as $document) {
            if (empty($document->id) || empty($document->type)) {
                continue;
            }

            if ($document->id === $uuid && $document->type === $type) {
                return $document;
            }
        }
        return null;
    }
}
