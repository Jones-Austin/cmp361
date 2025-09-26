<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Brand Viewer</title>
</head>
<body>
    <div class="container">
        <h1>Car Brands</h1>
        <?php
            $apiUrl = 'http://localhost:8004/api/v1/cars'; 
            
            $itemsPerPage = 3;

            // Fetch the JSON data from the API
            $json_data = @file_get_contents($apiUrl);

            if ($json_data === false) {
                echo "<div class='error'><strong>Connection Error:</strong> Could not connect to the API. Please ensure your Node.js server is running on port 8004.</div>";
            } else {
                
                $allBrands = json_decode($json_data, true);

                if (is_array($allBrands) && !empty($allBrands)) {
                    -
                    $totalBrands = count($allBrands);
                    $totalPages = ceil($totalBrands / $itemsPerPage);

                    $currentPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
                        'options' => ['default' => 1, 'min_range' => 1]
                    ]);
                    if ($currentPage > $totalPages) {
                        $currentPage = $totalPages;
                    }
                    $offset = ($currentPage - 1) * $itemsPerPage;

                    $brandsForPage = array_slice($allBrands, $offset, $itemsPerPage);
                    // loop through and display the brands
                    echo '<ul class="brand-list">';
                    foreach ($brandsForPage as $brand) {
                        echo '<li>' . htmlspecialchars($brand['carbrand']) . '</li>';
                    }
                    echo '</ul>';
                    if ($totalPages > 1) {
                        echo '<div class="pagination">';
                        if ($currentPage > 1) {
                            echo '<a href="?page=' . ($currentPage - 1) . '">&laquo; Previous</a>';
                        } else {
                            echo '<span class="disabled">&laquo; Previous</span>';
                        }
                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i == $currentPage) {
                                echo '<span class="current-page">' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . '">' . $i . '</a>';
                            }
                        }
                        if ($currentPage < $totalPages) {
                            echo '<a href="?page=' . ($currentPage + 1) . '">Next &raquo;</a>';
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