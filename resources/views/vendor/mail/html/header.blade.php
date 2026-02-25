@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ isset($message) ? $message->embed(str_replace('\\', '/', public_path('assets/img/logo/stay-smart.png'))) : asset('assets/img/logo/stay-smart.png') }}"
                class="logo" alt="Stay Smart Logo" style="width: 150px; height: auto;">
        </a>
    </td>
</tr>