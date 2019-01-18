<?php
use PHPUnit\Framework\TestCase;
use PFF\TCGplayerAPI;

class TCGplayerAPITest extends TestCase
{
    public function setUp()
    {
        $this->tcgplayerV_1_3 = new TCGplayerAPI(false, "https://api.tcgplayer.com/v1.3.0/");
        $this->tcgplayerV_1_20 = new TCGplayerAPI(false, "https://api.tcgplayer.com/v1.20.0/");
        $this->tcgplayerV_1_20->auth(false);
        $this->tcgplayerV_1_3->access_token = $this->tcgplayerV_1_20->access_token;
        $this->tcgplayerV_1_3->userName = $this->tcgplayerV_1_20->userName;
        $this->tcgplayerV_1_3->store_token = $this->tcgplayerV_1_20->store_token;
    }

    public function testCategoriesResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getAllCategories(),
        $this->tcgplayerV_1_20->getAllCategories()
      );
    }

    public function testSingleCategoryManifestResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getSingleCategoryManifest(),
        $this->tcgplayerV_1_20->getSingleCategoryManifest()
      );
    }

    public function testGetGroupsResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getGroups(),
        $this->tcgplayerV_1_20->getGroups()
      );
    }

    public function testGetGroupSkuPricesResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getGroupSkuPrices(370),
        $this->tcgplayerV_1_20->getGroupSkuPrices(370)
      );
    }

    public function testGetWholeSetResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getWholeSet(),
        $this->tcgplayerV_1_20->getWholeSet()
      );
    }

    public function testGetSingleItemResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getSingleItem(),
        $this->tcgplayerV_1_20->getSingleItem()
      );
    }

    public function testGetBuylistDataByExpansionResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getBuylistDataByExpansion(),
        $this->tcgplayerV_1_20->getBuylistDataByExpansion()
      );
    }

    public function testGetGroupBuylistDataResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getGroupBuylistData(),
        $this->tcgplayerV_1_20->getGroupBuylistData()
      );
    }

    public function testGetMarketPriceDataByExpansionResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getMarketPriceDataByExpansion(),
        $this->tcgplayerV_1_20->getMarketPriceDataByExpansion()
      );
    }

    /*public function testAuthStoreResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getSingleCategoryManifest(),
        $this->tcgplayerV_1_20->getSingleCategoryManifest()
      );
    }*/

    /*public function testGetStoreInfoResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getStoreInfo(),
        $this->tcgplayerV_1_20->getStoreInfo()
      );
    }*/

    public function testGetProductsByGroupIdMatchesBetweenVersionsResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getProductsByGroupId(),
        $this->tcgplayerV_1_20->getProductsByGroupId()
      );
    }

    public function testGetProductsMatchesBetweenVersionsResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getProducts(),
        $this->tcgplayerV_1_20->getProducts()
      );
    }

    public function testGetStoreCategoriesResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getStoreCategories(),
        $this->tcgplayerV_1_20->getStoreCategories()
      );
    }

    /*
    public function testUpdateSKUPriceResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->updateSKUPrice(),
        $this->tcgplayerV_1_20->updateSKUPrice()
      );
    }
    */

    public function testGetStoreInventoryResponseMatchesBetweenVersions()
    {
      $this->assertEquals(
        $this->tcgplayerV_1_3->getStoreInventory(),
        $this->tcgplayerV_1_20->getStoreInventory()
      );
    }
}
