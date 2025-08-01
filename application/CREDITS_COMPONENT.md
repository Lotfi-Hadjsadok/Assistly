# User Credits Livewire Component

## Overview

The `UserCredits` Livewire component displays the current user's credits in the sidebar and automatically refreshes when training operations complete.

## Files Created/Modified

### New Files
- `app/Livewire/Components/UserCredits.php` - The Livewire component class
- `resources/views/livewire/components/user-credits.blade.php` - The component view
- `tests/Feature/UserCreditsComponentTest.php` - Test file for the component

### Modified Files
- `resources/views/components/sidebar.blade.php` - Updated to use the new component
- `app/Livewire/Page/Knowledge/WebsiteRow.php` - Added credits update event dispatch
- `app/Livewire/Page/Knowledge/DocumentRow.php` - Added credits update event dispatch

## How It Works

1. **Component Structure**: The `UserCredits` component displays the current user's `credits` and `knowledge_credits` values.

2. **Event Listening**: The component listens for the `creditsUpdated` event using the `#[On('creditsUpdated')]` attribute.

3. **Event Dispatching**: When training operations complete successfully, the training components dispatch the `creditsUpdated` event:
   - `WebsiteRow::trainWebsite()` - Dispatches after successful website training
   - `DocumentRow::trainDocument()` - Dispatches after successful document training

4. **Automatic Refresh**: When the event is dispatched, the component automatically re-renders with the updated credit values.

## Usage

The component is automatically included in the sidebar and requires no additional setup. It will:

- Display current credit values
- Automatically refresh when training operations complete
- Show updated values without page refresh

## Testing

The component includes tests to verify:
- Proper rendering of credit values
- Event-driven refresh functionality

Run tests with: `php artisan test tests/Feature/UserCreditsComponentTest.php` 