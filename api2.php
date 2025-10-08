<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Brand Viewer</title>
</head>
<body>
    <div class="container">
        <?php
            function toggleSortOrder($currentDirection) {
                return ($currentDirection === 'asc') ? 'desc' : 'asc';
            }

            $apiUrl = 'http://localhost:8004/api/v1/cars'; 
            $itemsPerPage = 3;

            
            $json_data = @file_get_contents($apiUrl);

            if ($json_data === false) {
                echo "<div class='error'><strong>Connection Error:</strong> Could not connect to the API. Please ensure your Node.js server is running on port 8004.</div>";
            } else {
                
                $allBrands = json_decode($json_data, true);

                if (is_array($allBrands) && !empty($allBrands)) {
                    
                    
                    $sort_column = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'carbrand';
                    $sort_direction = strtolower(filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'asc');
                    if ($sort_direction !== 'asc' && $sort_direction !== 'desc') {
                        $sort_direction = 'asc';
                    }

                    // SORT THE DATA
                    usort($allBrands, function($a, $b) use ($sort_column, $sort_direction) {
                        if ($sort_direction === 'asc') {
                            return strcmp($a[$sort_column], $b[$sort_column]);
                        } else {
                            return strcmp($b[$sort_column], $a[$sort_column]);
                        }
                    });
                    
                    $totalBrands = count($allBrands);
                    $totalPages = ceil($totalBrands / $itemsPerPage);

                    $currentPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);
                    if ($currentPage > $totalPages && $totalPages > 0) {
                        $currentPage = $totalPages;
                    }
                    $offset = ($currentPage - 1) * $itemsPerPage;
                    $brandsForPage = array_slice($allBrands, $offset, $itemsPerPage);

                    $sort_url = "?sort={$sort_column}&dir=" . toggleSortOrder($sort_direction);
                    echo "<h1><a href='{$sort_url}'>Car Brands</a></h1>";

                    // 5. DISPLAY
                    echo '<ul class="brand-list">';
                    foreach ($brandsForPage as $brand) {
                        echo '<li>' . htmlspecialchars($brand['carbrand']) . '</li>';
                    }
                    echo '</ul>';
                
                    if ($totalPages > 1) {
                        echo '<div class="pagination">';
                        $sort_params = "&sort={$sort_column}&dir={$sort_direction}";

                        if ($currentPage > 1) {
                            echo '<a href="?page=' . ($currentPage - 1) . $sort_params . '">&laquo; Previous</a>';
                        } else {
                            echo '<span class="disabled">&laquo; Previous</span>';
                        }
                        
                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i == $currentPage) {
                                echo '<span class="current-page">' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . $sort_params . '">' . $i . '</a>';
                            }
                        }
                        
                        if ($currentPage < $totalPages) {
                            echo '<a href="?page=' . ($currentPage + 1) . $sort_params . '">Next &raquo;</a>';
                        } else {
                            echo '<span class="disabled">Next &raquo;</span>';
                        }
                        echo '</div>'; 
                    }

                } else {
                    echo "<div class='error'>No car brands found or the API returned invalid data.</div>";
                }
            }
        ?>
    </div>
</body>
</html>