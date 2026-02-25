<?php

require_once '../vendor/autoload.php';

use Pagerfanta\Pagerfanta;

/**
 * =====================================================
 * LOAD PRODUCTS
 * =====================================================
 * @throws JsonException
 */
function getProducts(): array
{
    $file = __DIR__ . '/../data/catalog.json';

    if (!is_file($file)) {
        return [];
    }

    return json_decode(
        file_get_contents($file),
        true,
        512,
        JSON_THROW_ON_ERROR
    ) ?? [];
}

/**
 * =====================================================
 * GET ONE PRODUCT
 * =====================================================
 * @throws JsonException
 */
function getProduct(string $id): ?array
{
    return array_find(getProducts(), fn($product) => ($product['id'] ?? null) === $id);
}

/**
 * =====================================================
 * ESCAPE HTML
 * =====================================================
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * =====================================================
 * SAFE SPEC ACCESS (IMPORTANT)
 * =====================================================
 */
function spec(array $product, string $key): mixed
{
    return $product['specs'][$key] ?? null;
}

/**
 * =====================================================
 * PAGINATION RENDER
 * =====================================================
 * @throws \JsonException
 */
            function renderPagination(Pagerfanta $pagerfanta): void
{
    $totalPages  = $pagerfanta->getNbPages();
    $currentPage = $pagerfanta->getCurrentPage();
    $window      = 2; // how many pages before/after current

    if ($totalPages <= 1) {
        return;
    }

    echo '<nav>';

    // Previous button
    if ($pagerfanta->hasPreviousPage()) {
        echo '<a href="?page=' . $pagerfanta->getPreviousPage() . '">&laquo; Précédent</a>';
    }

    // Calculate window range
    $start = max(1, $currentPage - $window);
    $end   = min($totalPages, $currentPage + $window);

    // Always show first page
    if ($start > 1) {
        echo '<a href="?page=1">1</a>';
        if ($start > 2) {
            echo '<span class="dots">...</span>';
        }
    }

    // Middle pages
    for ($i = $start; $i <= $end; $i++) {
        if ($i === $currentPage) {
            echo '<span class="current">' . $i . '</span>';
        } else {
            echo '<a href="?page=' . $i . '">' . $i . '</a>';
        }
    }

    // Always show last page
    if ($end < $totalPages) {
        if ($end < $totalPages - 1) {
            echo '<span class="dots">...</span>';
        }
        echo '<a href="?page=' . $totalPages . '">' . $totalPages . '</a>';
    }

    // Next button
    if ($pagerfanta->hasNextPage()) {
        echo '<a href="?page=' . $pagerfanta->getNextPage() . '">Suivant &raquo;</a>';
    }

    echo '</nav>';
}

/**
 * =====================================================
 * ROUTER
 * =====================================================
 */
function renderOneProduct(array $product): void
{
    $category = $product['category'] ?? null;
    $sub = $product['subcategory'] ?? null;

    match (true) {
        $category === 'Composants' && $sub === 'Carte graphique' => renderGpuCard($product),
        $category === 'Composants' && $sub === 'Processeur' => renderCpuCard($product),
        $category === 'Composants' && $sub === 'Mémoire RAM' => renderRamCard($product),
        $category === 'Composants' && $sub === 'Stockage' => renderStorageCard($product),
        $category === 'Écrans' => renderScreenCard($product, $sub),
        $category === 'Accessoires' && $sub === 'Housse' => renderHousseCard($product),
        $category === 'Accessoires' && $sub === 'Support' => renderSupportCard($product),
        $category === 'Accessoires' && $sub === 'Câble' => renderCableCard($product),
        default => var_dump($category, $sub),
    };
}

/**
 * =====================================================
 * GPU
 * =====================================================
 */
function renderGpuCard(array $product): void
{ ?>
    <div class="product-card" data-category="Composants" data-sub-category="Carte graphique">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'vram_gb')) ?></p>
            <p><?= e(spec($product, 'tdp_watts')) ?></p>
            <p><?= e(spec($product, 'ray_tracing')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>
        </div>
    </div>
<?php }

/**
 * =====================================================
 * CPU
 * =====================================================
 */
function renderCpuCard(array $product): void
{ ?>
    <div class="product-card" data-category="Composants" data-sub-category="Processeur">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >

        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'cores')) ?></p>
            <p><?= e(spec($product, 'threads')) ?></p>
            <p><?= e(spec($product, 'base_clock_ghz')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>
        </div>
    </div>
<?php }

/**
 * =====================================================
 * RAM
 * =====================================================
 */
function renderRamCard(array $product): void
{ ?>
    <div class="product-card" data-category="Composants" data-sub-category="Mémoire RAM">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'capacity_gb')) ?></p>
            <p><?= e(spec($product, 'frequency_mhz')) ?></p>
            <p><?= e(spec($product, 'type_ram')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>
        </div>
    </div>
<?php }

/**
 * =====================================================
 * STORAGE
 * =====================================================
 */
function renderStorageCard(array $product): void
{ ?>
    <div class="product-card" data-category="Composants" data-sub-category="Stockage">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'capacity_gb')) ?></p>
            <p><?= e(spec($product, 'type')) ?></p>
            <p><?= e(spec($product, 'read_speed_mbps')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>
        </div>
    </div>
<?php }

/**
 * =====================================================
 * SCREEN
 * =====================================================
 */
function renderScreenCard(array $product, string $subCategory): void
{ ?>
    <div class="product-card" data-category="Écrans" data-sub-category="<?= e($subCategory) ?>">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'screen_size_inches')) ?></p>
            <p><?= e(spec($product, 'resolution')) ?></p>
            <p><?= e(spec($product, 'refresh_rate_hz')) ?></p>
            <p><?= e(spec($product, 'panel_type')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>
        </div>

    </div>
<?php }

/**
 * =====================================================
 * ACCESSOIRE : HOUSSE
 * =====================================================
 */
function renderHousseCard(array $product): void
{ ?>
    <div class="product-card" data-category="Accessoires" data-sub-category="Housse">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'compatibilite')) ?></p>
            <p><?= e(spec($product, 'dimensions')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>

        </div>
    </div>
<?php }

/**
 * =====================================================
 * ACCESSOIRE : SUPPORT
 * =====================================================
 */
function renderSupportCard(array $product): void
{ ?>
    <div class="product-card" data-category="Accessoires" data-sub-category="Support">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'compatibilite')) ?></p>
            <p><?= e(spec($product, 'material')) ?></p>
            <p><?= e(spec($product, 'max_weight_kg')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>

        </div>
    </div>
<?php }

/**
 * =====================================================
 * ACCESSOIRE : CABLE
 * =====================================================
 */
function renderCableCard(array $product): void
{ ?>
    <div class="product-card" data-category="Accessoires" data-sub-category="Câble">
        <img alt="<?= e($product['model']) ?>" src="<?= e($product['image_url']) ?>" >
        <div class="container">
            <h2><?= e($product['model']) ?></h2>
            <p><?= e($product['brand']) ?></p>
            <p><?= e($product['range']) ?></p>
            <p><?= e($product['price']) ?></p>
            <p><?= e($product['rating']) ?></p>
            <p><?= e($product['stock']) ?></p>
            <p><?= e(spec($product, 'compatibilite')) ?></p>
            <p><?= e(spec($product, 'length_m')) ?></p>
            <p><?= e(spec($product, 'type_connection')) ?></p>
            <a href="?id=<?php echo $product['id']; ?>">Voir</a>

        </div>
    </div>
<?php }
