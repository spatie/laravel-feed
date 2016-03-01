<?php

  class NewsItem extends ModuleModel implements FeedItem
  {
  ...
      public function getFeedData() : array
      {
          return [
              'title' => $this->getFeedItemTitle(),
              'id' => $this->getFeedItemId(),
              'updated' => $this->getFeedItemUpdated(),
              'summary' => $this->getFeedItemSummary(),
              'link' => $this->getFeedItemLink(),
          ];
      }

      public function getFeedItemId()
      {
          return $this->id;
      }

      public function getFeedItemTitle() : string
      {
          return $this->name;
      }

      public function getFeedItemSummary() : string
      {
          return $this->present()->excerpt;
      }

      public function getFeedItemUpdated() : Carbon
      {
          return $this->updated_at;
      }

      public function getFeedItemLink() : string
      {
          return action('Front\NewsItemController@detail', [$this->url]);
      }
  }
