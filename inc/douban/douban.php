<?php
ini_set('max_execution_time', '0');
require_once 'simple_html_dom.php';


/**
 * 按符号截取字符串的指定部分
 * @param string $str 需要截取的字符串
 * @param string $sign 需要截取的符号
 * @param int $number 如是正数以0为起点从左向右截 负数则从右向左截
 * @return string 返回截取的内容
 */
function cut_str($str, $sign, $number)
{
  $array = explode($sign, $str);
  $length = count($array);
  if ($number < 0) {
    $new_array = array_reverse($array);
    $abs_number = abs($number);
    if ($abs_number > $length) {
      return 'error';
    } else {
      return $new_array[$abs_number - 1];
    }
  } else {
    if ($number >= $length) {
      return 'error';
    } else {
      return $array[$number];
    }
  }
}
class DoubanAPI
{
  /**
   * 从本地读取缓存信息，若不存在则创建，若过期则更新。并返回格式化 JtextContentSON
   * 
   * @access  public 
   * @param   string    $UserID             豆瓣ID
   * @param   int       $PageSize           分页大小
   * @param   int       $From               开始位置
   * @param   int       $ValidTimeSpan      有效时间，Unix 时间戳，s
   * @return  json      返回格式化影单
   */
  public static function updateMovieCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan)
  {
    if (!$UserID) {
      return json_encode(array('code' => '0', 'data' => '', 'msg' => '请在后台填写豆瓣用户ID'));
    }
    $expired = self::__isCacheExpired(__DIR__ . '/cache/movie.json', $ValidTimeSpan);
    if ($expired != 0) {
      $oldData = json_decode(file_get_contents(__DIR__ . '/cache/movie.json'))->data;
      $data = self::__getMovieRawData($UserID, $oldData[0]->name);
      // echo json_encode($data);
      array_splice($oldData, 0, 0, $data);
      $file = fopen(__DIR__ . '/cache/movie.json', "w");
      fwrite($file, json_encode(array('time' => time(), 'data' => $oldData)));
      fclose($file);
      $data = $oldData;
      foreach ((array)$data as $index => $value) {
        if ($value->name === '') unset($data[$index]);
      }
      // 清理空数组
      $total = count($data);
      if ($From < 0 || $From > $total - 1) echo json_encode(array());
      else {
        $end = min($From + $PageSize, $total);
        $out = array();
        for ($index = $From; $index < $end; $index++) {
          array_push($out, $data[$index]);
        }
        return json_encode(array('code' => '1', 'data' => $out, 'total' => $total));
      }
    } else {
      $data = json_decode(file_get_contents(__DIR__ . '/cache/movie.json'))->data;
      // 清理空数组
      foreach ((array)$data as $index => $value) {
        if ($value->name === '') unset($data[$index]);
      }
      $total = count($data);
      if ($From < 0 || $From > $total - 1) echo json_encode(array());
      else {
        $end = min($From + $PageSize, $total);
        $out = array();
        for ($index = $From; $index < $end; $index++) {
          array_push($out, $data[$index]);
        }
        return json_encode(array('code' => '1', 'data' => $out, 'total' => $total));
      }
    }
  }
  /**
   * 检查缓存是否过期
   * 
   * @access  private
   * @param   string    $FilePath           缓存路径
   * @param   int       $ValidTimeSpan      有效时间，Unix 时间戳，s
   * @return  int       0: 未过期; 1:已过期; -1：无缓存或缓存无效
   */
  private static function __isCacheExpired($FilePath, $ValidTimeSpan)
  {
    $file = fopen($FilePath, "r");
    if (!$file) {
      $file = fopen($FilePath, "w");
      fwrite($file, json_encode(array('code' => '1', 'time' => '946656000', 'data' => array(array("name" => "", "img" => "", "url" => "", "remark" => "", "date" => "", "year" => "", "mark_myself" => "", "mark_douban" => "")))));
      return -1;
    }
    $content = json_decode(fread($file, filesize($FilePath)));
    fclose($file);
    if (!$content->time || $content->time < 1) return -1;
    if (time() - $content->time > $ValidTimeSpan) return 1;
    return 0;
  }
  /**
   * 从豆瓣网页解析影单数据
   * 
   * @access  private
   * @param   string    $UserID     豆瓣ID
   * @return  array     返回格式化 array
   */
  private static function __getMovieRawData($UserID, $oldData)
  {
    $api = 'https://movie.douban.com/people/' . $UserID . '/collect';

    $data = array();
    while ($api != null) {
      $raw = self::curl_file_get_contents($api);
      if ($raw == null || $raw == "" || !$raw) break;
      $doc = new simple_html_dom;
      $doc->load($raw);
      $itemArray = $doc->find("div.item");
      foreach ((array)$itemArray as $v) {
        $t = $v->find("li.title", 0);
        $r = $v->find("li", 3);
        $m = $v->find("li", 2);
        
        // 获取电影名称
        $movie_name = str_replace(strstr(str_replace(
          array(" ", "　", "\t", "\n", "\r"),
          array("", "", "", "", ""),
          $t->text()
        ), "/"), "", str_replace(
          array(" ", "　", "\t", "\n", "\r"),
          array("", "", "", "", ""),
          $t->text()
        ));
        
        $movie_img  = $v->find("div.pic a img", 0)->src;
        $movie_url  = $t->find("a", 0)->href;
        $movie_remark  = $r->find("span.comment", 0) ? trim($r->find("span.comment", 0)->text()) : '';
        
        // 获取个人评分
        $movie_mark_myself = '';
        $movie_mark_myself_before =  $m->find("span", 0)->class;
        $movie_mark_myself  = $movie_mark_myself_before ? floatval(preg_replace('/[^0-9]/', '', $movie_mark_myself_before) * 2) : '';
        
        // 获取观看日期
        $movie_date_before = $m->find("span", 1)->text();
        $movie_date = $movie_date_before ? str_replace("\"", "\'", trim($movie_date_before)) : '';
        
        // 从日期中提取年份
        $movie_year = '';
        if ($movie_date) {
          // 尝试从日期字符串中提取年份（格式可能是 "2024-01-01" 或 "2024年1月1日"）
          if (preg_match('/(\d{4})/', $movie_date, $matches)) {
            $movie_year = $matches[1];
          }
        }
        
        // 获取豆瓣官方评分 - 方法1：从列表页获取
        $movie_mark_douban = '';
        // 尝试从列表页的评分区域获取（多种可能的class名称）
        $rating_selectors = array("span.rating", "span[class*=rating]", "div.rating");
        foreach ($rating_selectors as $selector) {
          $rating_span = $v->find($selector, 0);
          if ($rating_span) {
            $rating_class = $rating_span->class;
            // 匹配 rating5-t, rating45-t 等格式
            if (preg_match('/rating(\d+)-t/', $rating_class, $matches)) {
              $movie_mark_douban = floatval($matches[1]) / 10; // 转换为10分制
              break;
            }
            // 匹配其他可能的格式
            if (preg_match('/rating(\d+)/', $rating_class, $matches)) {
              $rating_value = floatval($matches[1]);
              if ($rating_value > 0 && $rating_value <= 50) {
                $movie_mark_douban = $rating_value / 10;
                break;
              }
            }
          }
        }
        
        // 方法2：尝试从列表页的文本中提取评分
        if (empty($movie_mark_douban)) {
          $info_text = $v->plaintext;
          // 查找类似 "8.5" 的评分格式
          if (preg_match('/(\d+\.\d+)\s*分/', $info_text, $matches)) {
            $potential_rating = floatval($matches[1]);
            if ($potential_rating >= 0 && $potential_rating <= 10) {
              $movie_mark_douban = $potential_rating;
            }
          }
        }
        
        // 方法3：如果列表页没有评分，尝试从详情页获取（延迟获取，避免频繁请求）
        // 注意：这里可以选择是否启用详情页获取，因为会增加请求次数
        // 如果启用，建议添加缓存机制
        if (empty($movie_mark_douban) && $movie_url && false) { // 默认关闭，避免过多请求
          $movie_mark_douban = self::__getMovieRatingFromDetail($movie_url);
          // 添加延迟，避免请求过快
          usleep(500000); // 0.5秒延迟
        }
        
        // 如果还是没有年份，尝试从电影名称后的信息中获取年份
        if (empty($movie_year)) {
          $title_text = $t->text();
          // 提取年份（通常在电影名称后，格式如 "2024"）
          // 只匹配1900-2099之间的年份，避免误匹配
          if (preg_match('/\b(19\d{2}|20\d{2})\b/', $title_text, $year_matches)) {
            $movie_year = $year_matches[1];
          }
        }
        
        if ($oldData == $movie_name) return $data;
        
        $data[] = array(
          "name" => $movie_name, 
          "img" => 'https://images.weserv.nl/?url=' . $movie_img, 
          "url" => $movie_url, 
          "remark" => $movie_remark, 
          "date" => $movie_date,
          "year" => $movie_year,
          "mark_myself" => $movie_mark_myself, 
          "mark_douban" => $movie_mark_douban
        );
      }
      $url = $doc->find("span.next a", 0);
      if ($url) {
        $api = "https://movie.douban.com" . $url->href;
      } else {
        $api = null;
      }
    }
    return $data;
  }
  
  /**
   * 从电影详情页获取豆瓣官方评分
   * 
   * @access  private
   * @param   string    $movieUrl     电影详情页URL
   * @return  float     返回评分，失败返回空字符串
   */
  private static function __getMovieRatingFromDetail($movieUrl)
  {
    try {
      $raw_movie = self::curl_file_get_contents($movieUrl);
      if (!$raw_movie) return '';
      
      $doc_movie = new simple_html_dom;
      $doc_movie->load($raw_movie);
      
      // 方法1: 查找 strong.rating_num
      $rating_elem = $doc_movie->find("strong.rating_num", 0);
      if ($rating_elem) {
        $rating_text = trim($rating_elem->text());
        if ($rating_text && is_numeric($rating_text)) {
          return floatval($rating_text);
        }
      }
      
      // 方法2: 查找评分相关的其他元素
      $rating_span = $doc_movie->find("span[property=v:average]", 0);
      if ($rating_span) {
        $rating_text = trim($rating_span->text());
        if ($rating_text && is_numeric($rating_text)) {
          return floatval($rating_text);
        }
      }
      
      // 方法3: 从评分区域查找
      $rating_wrapper = $doc_movie->find("div.rating_wrap", 0);
      if ($rating_wrapper) {
        $rating_num = $rating_wrapper->find("strong", 0);
        if ($rating_num) {
          $rating_text = trim($rating_num->text());
          if ($rating_text && is_numeric($rating_text)) {
            return floatval($rating_text);
          }
        }
      }
      
      return '';
    } catch (Exception $e) {
      return '';
    }
  }

  public static function curl_file_get_contents($_url)
  {
    $myCurl = curl_init($_url);
    //不验证证书
    curl_setopt($myCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($myCurl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($myCurl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($myCurl, CURLOPT_REFERER, 'https://www.douban.com');
    curl_setopt($myCurl, CURLOPT_HEADER, false);
    // 设置User-Agent，模拟浏览器访问
    curl_setopt($myCurl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    // 设置超时时间
    curl_setopt($myCurl, CURLOPT_TIMEOUT, 30);
    curl_setopt($myCurl, CURLOPT_CONNECTTIMEOUT, 10);
    // 跟随重定向
    curl_setopt($myCurl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($myCurl, CURLOPT_MAXREDIRS, 3);
    //获取
    $content = curl_exec($myCurl);
    $httpCode = curl_getinfo($myCurl, CURLINFO_HTTP_CODE);
    //关闭
    curl_close($myCurl);
    
    // 检查HTTP状态码
    if ($httpCode !== 200 || !$content) {
      return null;
    }
    
    return $content;
  }
}
class ParserDom
{
  /**
   * @var \DOMNode
   */
  public $node;
  /**
   * @var array
   */
  private $_lFind = [];
  /**
   * @param \DOMNode|string $node
   * @throws \Exception
   */
  public function __construct($node = NULL)
  {
    if ($node !== NULL) {
      if ($node instanceof \DOMNode) {
        $this->node = $node;
      } else {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->strictErrorChecking = FALSE;
        if (@$dom->loadHTML($node)) {
          $this->node = $dom;
        } else {
          throw new \Exception('load html error');
        }
      }
    }
  }
  /**
   * 初始化的时候可以不用传入html，后面可以多次使用
   * @param null $node
   * @throws \Exception
   */
  public function load($node = NULL)
  {
    if ($node instanceof \DOMNode) {
      $this->node = $node;
    } else {
      $dom = new \DOMDocument();
      $dom->preserveWhiteSpace = FALSE;
      $dom->strictErrorChecking = FALSE;
      if (@$dom->loadHTML($node)) {
        $this->node = $dom;
      } else {
        throw new \Exception('load html error');
      }
    }
  }
  /**
   * @codeCoverageIgnore
   * @param string $name
   * @return mixed
   */
  function __get($name)
  {
    switch ($name) {
      case 'outertext':
        return $this->outerHtml();
      case 'innertext':
        return $this->innerHtml();
      case 'plaintext':
        return $this->text();
      case 'href':
        return $this->getAttr("href");
      case 'src':
        return $this->getAttr("src");
      default:
        return NULL;
    }
  }
  /**
   * 深度优先查询
   *
   * @param string $selector
   * @param number $idx 找第几个,从0开始计算，null 表示都返回, 负数表示倒数第几个
   * @return self|self[]
   */
  public function find($selector, $idx = NULL)
  {
    if (empty($this->node->childNodes)) {
      return FALSE;
    }
    $selectors = $this->parse_selector($selector);
    if (($count = count($selectors)) === 0) {
      return FALSE;
    }
    for ($c = 0; $c < $count; $c++) {
      if (($level = count($selectors[$c])) === 0) {
        return FALSE;
      }
      $this->search($this->node, $idx, $selectors[$c], $level);
    }
    $found = $this->_lFind;
    $this->_lFind = [];
    if ($idx !== NULL) {
      if ($idx < 0) {
        $idx = count($found) + $idx;
      }
      if (isset($found[$idx])) {
        return $found[$idx];
      } else {
        return FALSE;
      }
    }
    return $found;
  }
  /**
   * 返回文本信息
   *
   * @return string
   */
  public function text()
  {
    return $this->text($this->node);
  }
  /**
   * 获取innerHtml
   * @return string
   */
  public function innerHtml()
  {
    $innerHTML = "";
    $children = $this->node->childNodes;
    foreach ((array)$children as $child) {
      $innerHTML .= $this->node->ownerDocument->saveHTML($child) ?: '';
    }
    return $innerHTML;
  }
  /**
   * 获取outerHtml
   * @return string|bool
   */
  public function outerHtml()
  {
    $doc = new \DOMDocument();
    $doc->appendChild($doc->importNode($this->node, TRUE));
    return $doc->saveHTML($doc);
  }
  /**
   * 获取html的元属值
   *
   * @param string $name
   * @return string|null
   */
  public function getAttr($name)
  {
    $oAttr = $this->node->attributes->getNamedItem($name);
    if (isset($oAttr)) {
      return $oAttr->nodeValue;
    }
    return NULL;
  }
  /**
   * 匹配
   *
   * @param string $exp
   * @param string $pattern
   * @param string $value
   * @return boolean|number
   */
  private function match($exp, $pattern, $value)
  {
    $pattern = strtolower($pattern);
    $value = strtolower($value);
    switch ($exp) {
      case '=':
        return ($value === $pattern);
      case '!=':
        return ($value !== $pattern);
      case '^=':
        return preg_match("/^" . preg_quote($pattern, '/') . "/", $value);
      case '$=':
        return preg_match("/" . preg_quote($pattern, '/') . "$/", $value);
      case '*=':
        if ($pattern[0] == '/') {
          return preg_match($pattern, $value);
        }
        return preg_match("/" . $pattern . "/i", $value);
    }
    return FALSE;
  }
  /**
   * 分析查询语句
   *
   * @param string $selector_string
   * @return array
   */
  private function parse_selector($selector_string)
  {
    $pattern = '/([\w\-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w\-:]+)(?:([!*^$]?=)["\']?(.*?)["\']?)?\])?([\/, ]+)/is';
    preg_match_all($pattern, trim($selector_string) . ' ', $matches, PREG_SET_ORDER);
    $selectors = [];
    $result = [];
    foreach ((array)$matches as $m) {
      $m[0] = trim($m[0]);
      if ($m[0] === '' || $m[0] === '/' || $m[0] === '//')
        continue;
      if ($m[1] === 'tbody')
        continue;
      list($tag, $key, $val, $exp, $no_key) = [$m[1], NULL, NULL, '=', FALSE];
      if (!empty($m[2])) {
        $key = 'id';
        $val = $m[2];
      }
      if (!empty($m[3])) {
        $key = 'class';
        $val = $m[3];
      }
      if (!empty($m[4])) {
        $key = $m[4];
      }
      if (!empty($m[5])) {
        $exp = $m[5];
      }
      if (!empty($m[6])) {
        $val = $m[6];
      }
      // convert to lowercase
      $tag = strtolower($tag);
      $key = strtolower($key);
      // elements that do NOT have the specified attribute
      if (isset($key[0]) && $key[0] === '!') {
        $key = substr($key, 1);
        $no_key = TRUE;
      }
      $result[] = [$tag, $key, $val, $exp, $no_key];
      if (trim($m[7]) === ',') {
        $selectors[] = $result;
        $result = [];
      }
    }
    if (count($result) > 0) {
      $selectors[] = $result;
    }
    return $selectors;
  }
  /**
   * 深度查询
   *
   * @param \DOMNode $search
   * @param          $idx
   * @param          $selectors
   * @param          $level
   * @param int $search_level
   * @return bool
   */
  private function search(&$search, $idx, $selectors, $level, $search_level = 0)
  {
    if ($search_level >= $level) {
      $rs = $this->seek($search, $selectors, $level - 1);
      if ($rs !== FALSE && $idx !== NULL) {
        if ($idx == count($this->_lFind)) {
          $this->_lFind[] = new self($rs);
          return TRUE;
        } else {
          $this->_lFind[] = new self($rs);
        }
      } elseif ($rs !== FALSE) {
        $this->_lFind[] = new self($rs);
      }
    }
    if (!empty($search->childNodes)) {
      foreach ((array)$search->childNodes as $val) {
        if ($this->search($val, $idx, $selectors, $level, $search_level + 1)) {
          return TRUE;
        }
      }
    }
    return FALSE;
  }
  /**
   * 获取tidy_node文本
   *
   * @param \DOMNode $node
   * @return string
   */
  private function textnew(&$node)
  {
    return $node->textContent;
  }
  /**
   * 匹配节点,由于采取的倒序查找，所以时间复杂度为n+m*l n为总节点数，m为匹配最后一个规则的个数，l为规则的深度,
   * @codeCoverageIgnore
   * @param \DOMNode $search
   * @param array $selectors
   * @param int $current
   * @return boolean|\DOMNode
   */
  private function seek($search, $selectors, $current)
  {
    if (!($search instanceof \DOMElement)) {
      return FALSE;
    }
    list($tag, $key, $val, $exp, $no_key) = $selectors[$current];
    $pass = TRUE;
    if ($tag === '*' && !$key) {
      exit('tag为*时，key不能为空');
    }
    if ($tag && $tag != $search->tagName && $tag !== '*') {
      $pass = FALSE;
    }
    if ($pass && $key) {
      if ($no_key) {
        if ($search->hasAttribute($key)) {
          $pass = FALSE;
        }
      } else {
        if ($key != "plaintext" && !$search->hasAttribute($key)) {
          $pass = FALSE;
        }
      }
    }
    if ($pass && $key && $val && $val !== '*') {
      if ($key == "plaintext") {
        $nodeKeyValue = $this->text($search);
      } else {
        $nodeKeyValue = $search->getAttribute($key);
      }
      $check = $this->match($exp, $val, $nodeKeyValue);
      if (!$check && strcasecmp($key, 'class') === 0) {
        foreach (explode(' ', $search->getAttribute($key)) as $k) {
          if (!empty($k)) {
            $check = $this->match($exp, $val, $k);
            if ($check) {
              break;
            }
          }
        }
      }
      if (!$check) {
        $pass = FALSE;
      }
    }
    if ($pass) {
      $current--;
      if ($current < 0) {
        return $search;
      } elseif ($this->seek($this->getParent($search), $selectors, $current)) {
        return $search;
      } else {
        return FALSE;
      }
    } else {
      return FALSE;
    }
  }
  /**
   * 获取父亲节点
   *
   * @param \DOMNode $node
   * @return \DOMNode
   */
  private function getParent($node)
  {
    return $node->parentNode;
  }
}
$ValidTimeSpan = 60 * 60 * 24;
$From = $_GET['from'];
$UserID = $_GET['db_id'];
$PageSize = $_GET['pageSize'];
$Type = $_GET['type'];

if ($Type == 'movie') {
  header("Content-type: application/json");
  echo DoubanAPI::updateMovieCacheAndReturn($UserID, $PageSize, $From, $ValidTimeSpan);
} else {
  echo json_encode(array());
}
