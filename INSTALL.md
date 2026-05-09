# Installation & Management Guide

This guide provides step-by-step instructions for installing, configuring, and maintaining the **Library Search** block.

## 1. Installation

### Via Git (Recommended)
1.  Open your terminal and navigate to your Moodle installation's `blocks` folder:
    ```bash
    cd /var/www/html/moodle/blocks
    ```
2.  Clone the repository:
    ```bash
    git clone https://github.com/DevOGee/OUK-Library-search-plugin.git librarysearch
    ```
3.  Set the correct permissions:
    ```bash
    chown -R www-data:www-data librarysearch
    ```
4.  Log in to Moodle as an admin and navigate to **Site administration > Notifications**.
5.  Follow the prompts to complete the database upgrade.

### Manual Upload
1.  Download the ZIP from GitHub.
2.  Unzip and rename the folder to `librarysearch`.
3.  Upload the folder to `/path/to/moodle/blocks/`.
4.  Follow steps 4-5 above.

## 2. Configuration

Navigate to **Site administration > Plugins > Blocks > Library Search**.

### Connection Settings
*   **Library Base URL**: The main URL of your library system (e.g., `https://library.ouk.ac.ke`).
*   **Search Path**: The query path (e.g., `/search?q=` or `/cgi-bin/koha/opac-search.pl?q=`).

### SSO Setup (Optional)
To enable Single Sign-On:
1.  Set **Enable SSO** to Yes.
2.  Select **HMAC Token** as the method.
3.  Generate a strong **Shared Secret** (min 32 chars) and enter it here.
4.  Configure your library system to expect the `sso_token` parameter and validate the signature using the same secret.

## 3. Adding the Block to the Dashboard

1.  Log in to Moodle as any user.
2.  Navigate to your **Dashboard**.
3.  Toggle **Edit mode** (top right).
4.  Click **Add a block** and select **Library Search**.
5.  Use the move icon to position it.

## 4. Updates & Upgrades

To update the plugin to the latest version:
1.  Navigate to the plugin folder:
    ```bash
    cd /var/www/html/moodle/blocks/librarysearch
    ```
2.  Pull the latest changes:
    ```bash
    git pull origin main
    ```
3.  Log in to Moodle and visit **Site administration > Notifications** to trigger any database updates.

## 5. Troubleshooting

*   **Block doesn't appear**: Ensure the folder name is exactly `librarysearch` and permissions are correct.
*   **Search redirects to wrong URL**: Double-check the **Library Base URL** and **Search Path** in admin settings.
*   **SSO failing**: Verify the **Shared Secret** matches on both Moodle and the Library system. Check Moodle's developer debugging logs.
