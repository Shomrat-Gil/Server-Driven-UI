# Server-Driven UI (SDUI) - README.md

## Overview

Server-Driven UI (SDUI) is an architectural approach that allows the server to dictate the structure and content of the user interface on the client side. Instead of hardcoding UI elements on the client, SDUI relies on a server to send the necessary components, layouts, and configurations dynamically to the client application. This approach offers flexibility, reduced client-side logic, and easier maintenance.

## Create Components

You can create your own components by extending `AbstractComponentClass`. Below are examples illustrating how to use the SDUI library:

## Usage

### Example 1:

```php
$sdui = SdUI::make()
    ->add(HeadingComponent::make()
        ->setTitle(TextStyleCard::make()->setValue('Main Heading'))
        ->setSubTitle(TextStyleCard::make()->setValue('Main Heading Subtitle')))
    ->append(HeadingComponent::make()->setTitle(TextStyleCard::make()->setValue('Item Heading')))
    ->append(LabelComponent::make()
        ->setTitle(TextStyleCard::make()->setValue('Hello World')->setBold(true))
        ->setStyle(['color' => '#000']))
    ->append(
        SdUI::make('banner')
            ->append(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Nested Lable')->setItalic(true)))
            ->append(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Another Nested Label')->setBold(true)))
    )
    ->render();

print_r($sdui);
```
### Example 2:

```php
$sdui = SdUI::make()
    ->setCurrentPageFetch('/api/boo/123')
    ->add(HeadingComponent::make()->setTitle(TextStyleCard::make()->setValue('Main Heading'))->setSubTitle(TextStyleCard::make()->setValue('Main Heading Subtitle')))
    ->append(HeadingComponent::make()->setTitle(TextStyleCard::make()->setValue('Item Heading')), 'group1')
    ->append(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Hello')), 'group1')
    ->append(
        SdUI::make()
            ->append(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Nested Lable')->setItalic(true)), 'group2')
            ->append(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Another Nested Lable')->setItalic(true)), 'group2')
    )
    ->append(
        InputFormComponent::make()
            ->setName('username')
            ->setLabel('Username')
            ->setType('text')
            ->setValidation('required') // Validates for non-empty
    )
    ->append(
        DropdownComponent::make()
            ->setName('country')
            ->setLabel('Select Country')
            ->addOption('US', 'United States')
            ->addOption('UK', 'United Kingdom')
            ->addOption('IN', 'India')
            ->setSelectedValue('US')
    )
    ->append(
        DropdownComponent::make()
            ->setName('language')
            ->setLabel('Choose Language')
            ->addOption('en', 'English')
            ->addOption('es', 'Spanish')
            ->addOption('fr', 'French')
    )
    ->appendAction(
        ActionCard::make()
            ->setLabel(TextStyleCard::make()->setValue('Back')->setColor('#000000')->setBackgroundColor('#888888'))
            ->setNavigationKey('BOO', 123)
            ->setStyleOutline()
    )
    ->appendAction(
        ActionCard::make()
            ->setLabel(TextStyleCard::make()->setValue('Save')->setColor('#000000')->setBackgroundColor('#888888'))
            ->setNavigationKey('FOO', 123)
            ->setSubmitForm('/api/foo')
            ->setSubmitConfirmationMessage('Are you sure?')
            ->setStyleOutline()
    )
    ->setPayload('stripe_account', 'xyz098')
    ->render();
// Output the rendered UI as an array
print_r($sdui);
``` 

### Example 3:

```php
$sdui = SdUI::make()
    ->addRow()  // Grouping key 'row1'
    ->appendColumn(HeadingComponent::make()->setTitle(TextStyleCard::make()->setValue('Column 1')))
    ->appendColumn(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Label 1')))
    ->addRow()  // Grouping key 'row2'
    ->appendColumn(LabelComponent::make()->setTitle(TextStyleCard::make()->setValue('Label 2')))
    ->render();

print_r($sdui);
```
## Key Features

1. **Dynamic Content Delivery**: The server determines what content to display and how it should be presented, allowing for real-time changes without requiring client-side updates.
  
2. **Reduced Client Logic**: By offloading UI decisions to the server, client applications can focus on rendering and user interactions without being burdened by complex UI logic.
  
3. **Consistency Across Platforms**: SDUI promotes a consistent user experience across different platforms and devices as the server ensures uniformity in UI components and layouts.
  
4. **Adaptive User Experience**: The server can tailor the UI based on user preferences, device capabilities, and contextual information, ensuring a personalized experience.

## How It Works

1. **Initialization**: The client application sends a request to the server, indicating its capabilities, device type, and other relevant information.
  
2. **Server Response**: Based on the client's request and other contextual factors, the server sends a structured response containing UI components, layouts, and configurations.
  
3. **Rendering**: The client application receives the server response and dynamically renders the UI based on the received specifications. Any subsequent updates or changes are also managed by the server.

## Advantages

- **Flexibility**: Easily modify UI elements, layouts, and configurations without updating the client application.
  
- **Scalability**: Handle a large number of users and devices with varying capabilities by centralizing UI logic on the server.
  
- **Maintenance**: Simplify updates, bug fixes, and feature enhancements by managing UI components centrally on the server.
  
- **Personalization**: Deliver tailored user experiences based on user preferences, behavior, and contextual information.

## Considerations

- **Network Dependency**: SDUI requires a stable network connection to fetch UI components from the server, which may introduce latency or reliability concerns.
  
- **Server Complexity**: The server-side logic for generating and delivering UI components can become complex, especially for large-scale applications.
  
- **Security**: Ensure secure communication between the client and server to prevent unauthorized access or tampering of UI components.

## Getting Started

To implement Server-Driven UI in your application:

1. Design a server-side infrastructure capable of generating dynamic UI components based on client requests.
2. Define a protocol or API specification for communication between the client and server.
3. Implement client-side logic to handle server responses and render UI components accordingly.
4. Test the implementation thoroughly to ensure seamless user experiences across different platforms and devices.

## Conclusion

Server-Driven UI offers a flexible, scalable, and maintainable approach to designing user interfaces by centralizing UI logic on the server. By dynamically delivering UI components and configurations to the client application, SDUI promotes consistency, adaptability, and personalization, enhancing the overall user experience.
