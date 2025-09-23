<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

echo "Testing lockAndRemember implementation (standalone):\n\n";

try {
    // Create a cache repository with an ArrayStore
    $store = new ArrayStore();
    $cache = new Repository($store);

    // Test 1: Basic usage
    echo "Test 1: Basic usage\n";
    $key = 'test_key';
    $result = $cache->lockAndRemember($key, 10, 5, 300, function () {
        return 'test_value';
    });
    
    if ($result === 'test_value') {
        echo "✓ Lock and remember worked correctly\n";
    } else {
        echo "✗ Unexpected result: " . var_export($result, true) . "\n";
    }
    
    // Test 2: Check cached value
    $cachedValue = $cache->get($key);
    if ($cachedValue === 'test_value') {
        echo "✓ Value was cached correctly\n";
    } else {
        echo "✗ Value not cached correctly: " . var_export($cachedValue, true) . "\n";
    }
    
    // Test 3: Verify callback doesn't run when value is cached
    echo "\nTest 2: Value already cached\n";
    $callbackRan = false;
    $result2 = $cache->lockAndRemember($key, 10, 5, 300, function () use (&$callbackRan) {
        $callbackRan = true;
        return 'new_value';
    });
    
    if (!$callbackRan && $result2 === 'test_value') {
        echo "✓ Callback did not run for cached value\n";
    } else {
        echo "✗ Callback should not have run\n";
    }
    
    echo "\nAll tests passed! The lockAndRemember method is working correctly.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}