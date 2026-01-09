#!/usr/bin/env python3
"""
Script to take full page screenshot of admin dashboard
Usage: python screenshot.py
"""

from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time
import os

def take_screenshot(url, output_path="screenshot.png", wait_time=3):
    """
    Take a full page screenshot of the given URL
    
    Args:
        url: The URL to screenshot
        output_path: Path to save the screenshot
        wait_time: Time to wait for page to load (in seconds)
    """
    # Setup Chrome options
    chrome_options = Options()
    chrome_options.add_argument('--headless')  # Run in background
    chrome_options.add_argument('--no-sandbox')
    chrome_options.add_argument('--disable-dev-shm-usage')
    chrome_options.add_argument('--disable-gpu')
    chrome_options.add_argument('--window-size=1920,1080')
    
    # Initialize the driver
    try:
        driver = webdriver.Chrome(options=chrome_options)
        
        print(f"Loading page: {url}")
        driver.get(url)
        
        # Wait for page to load
        print(f"Waiting {wait_time} seconds for page to load...")
        time.sleep(wait_time)
        
        # Wait for sidebar to be visible
        try:
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.CLASS_NAME, "crancy-smenu"))
            )
            print("Sidebar loaded successfully")
        except:
            print("Warning: Sidebar not found, continuing anyway...")
        
        # Scroll to top to ensure sidebar is fully visible
        driver.execute_script("window.scrollTo(0, 0);")
        time.sleep(1)
        
        # Get the total page height
        total_height = driver.execute_script("return document.body.scrollHeight")
        viewport_height = driver.execute_script("return window.innerHeight")
        
        print(f"Page height: {total_height}px")
        print(f"Viewport height: {viewport_height}px")
        
        # Take screenshot
        print(f"Taking screenshot...")
        driver.save_screenshot(output_path)
        
        print(f"Screenshot saved to: {output_path}")
        
        # Alternative: Full page screenshot using JavaScript
        # This method captures the entire page including non-visible parts
        print("\nTaking full page screenshot (alternative method)...")
        full_page_screenshot(output_path.replace('.png', '_full.png'), driver, total_height, viewport_height)
        
        driver.quit()
        print("Done!")
        
    except Exception as e:
        print(f"Error: {e}")
        if 'driver' in locals():
            driver.quit()
        raise

def full_page_screenshot(output_path, driver, total_height, viewport_height):
    """
    Take a full page screenshot by scrolling and stitching images
    """
    screenshots = []
    scroll_position = 0
    
    while scroll_position < total_height:
        # Scroll to position
        driver.execute_script(f"window.scrollTo(0, {scroll_position});")
        time.sleep(0.5)  # Wait for scroll
        
        # Take screenshot of current viewport
        screenshot_path = f"temp_screenshot_{scroll_position}.png"
        driver.save_screenshot(screenshot_path)
        screenshots.append((screenshot_path, scroll_position))
        
        scroll_position += viewport_height
    
    # Scroll back to top
    driver.execute_script("window.scrollTo(0, 0);")
    
    # Note: For full page stitching, you would need PIL/Pillow
    # For now, we'll just use the simple method
    print(f"Multiple screenshots saved. Use image editing software to stitch them.")
    print(f"Or use the simple screenshot method which captures the visible area.")

if __name__ == "__main__":
    # Configuration
    URL = "http://127.0.0.1:8000/admin/dashboard"
    OUTPUT_FILE = "admin_dashboard_screenshot.png"
    WAIT_TIME = 5  # seconds
    
    # Check if URL is provided as command line argument
    import sys
    if len(sys.argv) > 1:
        URL = sys.argv[1]
    if len(sys.argv) > 2:
        OUTPUT_FILE = sys.argv[2]
    
    print("=" * 50)
    print("Admin Dashboard Screenshot Tool")
    print("=" * 50)
    print(f"URL: {URL}")
    print(f"Output: {OUTPUT_FILE}")
    print("=" * 50)
    
    take_screenshot(URL, OUTPUT_FILE, WAIT_TIME)

