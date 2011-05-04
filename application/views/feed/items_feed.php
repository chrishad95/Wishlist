<?php 
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
    
    <title><?php echo $wishlist['title']; ?></title>

    <link><?php echo site_url('wishlists/show/' . $wishlist['id'] . '/' . url_title($wishlist['title'])); ?></link>
    <description><?php echo $wishlist['desc']; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $wishlist['owner'] ; ?></dc:creator>

    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

    <?php foreach($items as $item): ?>
    
        <item>

          <title><?php echo xml_convert($item['title']); ?></title>
          <link><?php echo site_url('wishlists/show_item/' . $item['id'] . '/' . url_title($item['title'])) ?></link>
          <guid><?php echo site_url('wishlists/show_item/' . $item['id'] . '/' . url_title($item['title'])) ?></guid>

          <description><?php echo $item['desc'] ; ?></description>
      <pubDate><?php echo $item['created_at'] ;?></pubDate>
        </item>

        
    <?php endforeach; ?>
    
    </channel>
</rss>  