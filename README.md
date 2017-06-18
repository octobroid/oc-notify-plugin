# Notification System for OctoberCMS Plugin

### Usage

```php
Notify::sendTo($recipient, [
    'from' => Auth::getUser(),
    'related' => $post,
    'template' => 'post.share',
    'data' => [
        'thread' => $thread->id,
    ],
]);
```

### Template

Every notification should refer to template that can be edited dynamically.

content:
```
Your post about #{{ related.id }} is shared to {{ thread.name }} by {{ from.name }}.
```

properties:
```
[thread]
class = 'Foo\Forum\Models\Thread'
```

link_page: `forum/thread`

link_data:
```
slug = '{{ thread.slug }}'
```