<?php
class StockSymbolDataBase
{
	public $symbol;
	public $name;
	public $date;
	public $isEnabled;
	public $type;
	public $iexId;
}

class StockSymbolData
{
	public $symbol;
	public $companyName;
	public $primaryExchange;
	public $sector;
	public $calculationPrice;
	public $open;
	public $openTime;
	public $close;
	public $closeTime;
	public $high;
	public $low;
	public $latestPrice;
	public $latestSource;
	public $latestTime;
	public $latestUpdate;
	public $latestVolume;
	public $iexRealtimePrice;
	public $iexRealtimeSize;
	public $iexLastUpdated;
	public $delayedPrice;
	public $delayedPriceTime;
	public $extendedPrice;
	public $extendedChange;
	public $extendedChangePercent;
	public $extendedPriceTime;
	public $previousClose;
	public $change;
	public $changePercent;
	public $iexMarketPercent;
	public $iexVolume;
	public $avgTotalVolume;
	public $iexBidPrice;
	public $iexBidSize;
	public $iexAskPrice;
	public $iexAskSize;
	public $marketCap;
	public $peRatio;
	public $week52High;
	public $week52Low;
	public $ytdChange;

	public $logo;

	public $news = array();
}

class StockNewsData
{
	public $datetime;
	public $headline;
	public $source;
	public $url;
	public $summary;
	public $related;
	public $image;
}

class Stock
{
	public $symbols = array();
	public $errors = array();
	public $names = array();

	public function __construct($s, $n)
	{
		$stockDbase = new Database();
		
		if ($s != null)
		{
			$symbs = explode(",", $s);

			foreach ($symbs as $sym)
			{
				$sql = sprintf("SELECT * FROM stockSymbols WHERE symbol='%s'", trim($sym));

				$stockDbase->ExecSql($sql);

				if ($stockDbase->GetRowCount() == 0)
				{
					$str = sprintf("%s: Not Found", $sym);
					
					array_push($this->errors, $str);
				}
				else
				{
					while($row = $stockDbase->FetchRow())
					{
						$this->GetRow($row);
					}
				}
			}
		}

		if ($n != null)
		{
			$sql = sprintf("SELECT * FROM stockSymbols WHERE name LIKE '%%%s%%' ORDER BY name", $n);

			$stockDbase->ExecSql($sql);

			if ($stockDbase->GetRowCount() == 0)
			{
				$str = sprintf("%s: Not Found", $n);
				
				array_push($this->errors, $str);
			}
			else
			{
				while($row = $stockDbase->FetchRow())
				{
					$this->GetRow($row);
				}
			}
		}

		$stockDbase->Disconnect();

		//API Token: pk_338ec58be83340189f482c362711d226 
		
		//$url = "https://cloud.iexapis.com/stable/stock/market/batch?token=pk_338ec58be83340189f482c362711d226&types=quote,news&last=5&symbols=" . $syms;
		
		$syms = null;
		
		foreach($this->names as $nm)
		{
			$syms .= $nm->symbol . ",";
		}

		$syms = rtrim($syms, ",");
		
		if ($syms != null)
		{
			$url = "https://cloud.iexapis.com/stable/stock/market/batch?token=pk_338ec58be83340189f482c362711d226&types=quote,news&last=5&symbols=" . $syms;
			
			$json = file_get_contents($url);

			$jsond = json_decode($json, true);

			foreach ($jsond as $item)
			{
				$stockSymbolData = new StockSymbolData();

				$stockSymbolData->symbol = $item["quote"]["symbol"];
				$stockSymbolData->companyName =  $item["quote"]["companyName"];
				$stockSymbolData->primaryExchange =  $item["quote"]["primaryExchange"];
				//$stockSymbolData->sector =  $item["quote"]["sector"];
				$stockSymbolData->calculationPrice =  $item["quote"]["calculationPrice"];
				$stockSymbolData->open =  $item["quote"]["open"];
				$stockSymbolData->openTime =  $item["quote"]["openTime"];
				$stockSymbolData->close =  $item["quote"]["close"];
				$stockSymbolData->closeTime =  $item["quote"]["closeTime"];
				$stockSymbolData->high =  $item["quote"]["high"];
				$stockSymbolData->low =  $item["quote"]["low"];
				$stockSymbolData->latestPrice =  $item["quote"]["latestPrice"];
				$stockSymbolData->latestSource =  $item["quote"]["latestSource"];
				$stockSymbolData->latestTime =  $item["quote"]["latestTime"];
				$stockSymbolData->latestUpdate =  $item["quote"]["latestUpdate"];
				$stockSymbolData->latestVolume =  $item["quote"]["latestVolume"];
				$stockSymbolData->iexRealtimePrice =  $item["quote"]["iexRealtimePrice"];
				$stockSymbolData->iexRealtimeSize =  $item["quote"]["iexRealtimeSize"];
				$stockSymbolData->iexLastUpdated =  $item["quote"]["iexLastUpdated"];
				$stockSymbolData->delayedPrice =  $item["quote"]["delayedPrice"];
				$stockSymbolData->delayedPriceTime =  $item["quote"]["delayedPriceTime"];
				$stockSymbolData->extendedPrice =  $item["quote"]["extendedPrice"];
				$stockSymbolData->extendedChange =  $item["quote"]["extendedChange"];
				$stockSymbolData->extendedChangePercent =  $item["quote"]["extendedChangePercent"];
				$stockSymbolData->extendedPriceTime =  $item["quote"]["extendedPriceTime"];
				$stockSymbolData->previousClose =  $item["quote"]["previousClose"];
				$stockSymbolData->change =  $item["quote"]["change"];
				$stockSymbolData->changePercent =  $item["quote"]["changePercent"];
				$stockSymbolData->iexMarketPercent =  $item["quote"]["iexMarketPercent"];
				$stockSymbolData->iexVolume =  $item["quote"]["iexVolume"];
				$stockSymbolData->avgTotalVolume =  $item["quote"]["avgTotalVolume"];
				$stockSymbolData->iexBidPrice =  $item["quote"]["iexBidPrice"];
				$stockSymbolData->iexBidSize =  $item["quote"]["iexBidSize"];
				$stockSymbolData->iexAskPrice =  $item["quote"]["iexAskPrice"];
				$stockSymbolData->iexAskSize =  $item["quote"]["iexAskSize"];
				$stockSymbolData->marketCap =  $item["quote"]["marketCap"];
				$stockSymbolData->peRatio =  $item["quote"]["peRatio"];
				$stockSymbolData->week52High =  $item["quote"]["week52High"];
				$stockSymbolData->week52Low =  $item["quote"]["week52Low"];
				$stockSymbolData->ytdChange =  $item["quote"]["ytdChange"];

				$stockSymbolData->logo = "https://storage.googleapis.com/iex/api/logos/" . $stockSymbolData->symbol . ".png";

				foreach ($item["news"] as $news)
				{
					$stockNewsData = new StockNewsData();

					$stockNewsData->datetime = $news["datetime"];
					$stockNewsData->headline = $news["headline"];
					$stockNewsData->source = $news["source"];
					$stockNewsData->url = $news["url"];
					$stockNewsData->summary = $news["summary"];
					$stockNewsData->related = $news["related"];
					$stockNewsData->image = $news["image"];

					array_push($stockSymbolData->news, $stockNewsData);
				}

				array_push($this->symbols, $stockSymbolData);
			}

			asort($this->symbols);
		}
	}

	public function GetRow($row)
	{
		$stockSymbolDataBase = new StockSymbolDataBase();

		$stockSymbolDataBase->symbol = $row["symbol"];
		$stockSymbolDataBase->name = $row["name"];
		$stockSymbolDataBase->date = $row["date"];
		$stockSymbolDataBase->isEnabled = $row["isEnabled"];
		$stockSymbolDataBase->type = $row["type"];
		$stockSymbolDataBase->iexId = $row["iexId"];

		array_push($this->names, $stockSymbolDataBase);
	}
}
?>