<?php
/**
 * Copyright (C) 2018 Adshares sp. z o.o.
 *
 * This file is part of ADS PHP Client
 *
 * ADS PHP Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ADS PHP Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ADS PHP Client.  If not, see <https://www.gnu.org/licenses/>
 */

namespace Adshares\Ads\Response;

/**
 * Response for GetBlockIds request.
 *
 * @package Adshares\Ads\Response
 */
class GetBlockIdsResponse extends AbstractResponse
{
    /**
     * Array of updated block ids. Can be empty, if all blocks in selected period were updated earlier.
     *
     * @var string[]
     */
    protected $blockIds = [];

    /**
     * Number of updated blocks. Value of 0 means that all blocks were updated in selected period.
     *
     * @var int
     */
    protected $updatedBlocks;

    /**
     * @param array $data
     */
    protected function loadData(array $data): void
    {
        parent::loadData($data);

        if (array_key_exists('blocks', $data)) {
            foreach ($data['blocks'] as $value) {
                $this->blockIds[] = $value;
            }
        }
        if (array_key_exists('updated_blocks', $data)) {
            $this->updatedBlocks = $data['updated_blocks'];
        }
    }

    /**
     * @return string[] Array of updated block ids. Can be empty,
     * if all blocks in selected period were updated earlier.
     */
    public function getBlockIds(): array
    {
        return $this->blockIds;
    }

    /**
     * @return int Number of updated blocks. Value of 0 means that all blocks were updated in selected period.
     */
    public function getUpdatedBlocks(): int
    {
        return $this->updatedBlocks;
    }
}
