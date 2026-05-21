<?php

namespace Iammuttaqi\FilamentFakester\Generators;

use Filament\Forms\Components\TextInput;
use Iammuttaqi\FilamentFakester\Support\MatcherRegistry;
use Illuminate\Support\Str;

class TextInputResolver
{
    public function __construct(protected MatcherRegistry $registry) {}

    public function resolve(TextInput $input): string
    {
        $name = (string) $input->getName();
        $type = (string) $input->getType();

        if (($custom = $this->registry->match($name, $type)) !== null) {
            return (string) $custom;
        }

        $eq = fn (string ...$k) => in_array($name, $k, true);
        $has = fn (string ...$f) => collect($f)->contains(fn ($x) => str_contains($name, $x));
        $ends = fn (string ...$s) => collect($s)->contains(fn ($x) => str_ends_with($name, $x));

        $by_name = match (true) {
            $eq('name', 'full_name') || $ends('_name') => fake()->name(),
            $eq('first_name') || $ends('_first_name') => fake()->firstName(),
            $eq('last_name', 'surname') || $ends('_last_name') => fake()->lastName(),
            $eq('username', 'handle') || $ends('_username') => fake()->userName(),
            $eq('slug') || $ends('_slug') => fake()->slug(nbWords: 3),
            $has('email') => fake()->safeEmail(),
            $has('phone', 'mobile') => fake()->phoneNumber(),
            $has('company', 'business') => fake()->company(),
            $eq('job_title', 'position', 'role') => fake()->jobTitle(),
            $eq('address') || $has('street', 'address_line') => fake()->streetAddress(),
            $eq('city') || $ends('_city') => fake()->city(),
            $eq('state', 'province') || $ends('_state') => fake()->state(),
            $eq('country') || $ends('_country') => fake()->country(),
            $eq('zip', 'postal_code', 'postcode', 'zip_code') => fake()->postcode(),
            $eq('latitude', 'lat') => fake()->randomFloat(6, -90, 90),
            $eq('longitude', 'lng', 'lon') => fake()->randomFloat(6, -180, 180),
            $eq('facebook', 'fb') || $has('facebook') => 'https://facebook.com/' . fake()->userName(),
            $eq('instagram', 'ig') || $has('instagram') => 'https://instagram.com/' . fake()->userName(),
            $eq('twitter', 'x') || $has('twitter') => 'https://x.com/' . fake()->userName(),
            $eq('linkedin') || $has('linkedin') => 'https://linkedin.com/in/' . fake()->userName(),
            $eq('youtube', 'yt') || $has('youtube') => 'https://youtube.com/@' . fake()->userName(),
            $eq('threads') || $has('threads') => 'https://threads.net/@' . fake()->userName(),
            $eq('tiktok') || $has('tiktok') => 'https://tiktok.com/@' . fake()->userName(),
            $eq('pinterest') || $has('pinterest') => 'https://pinterest.com/' . fake()->userName(),
            $eq('reddit') || $has('reddit') => 'https://reddit.com/user/' . fake()->userName(),
            $eq('github', 'gh') || $has('github') => 'https://github.com/' . fake()->userName(),
            $eq('gitlab') || $has('gitlab') => 'https://gitlab.com/' . fake()->userName(),
            $eq('bitbucket') || $has('bitbucket') => 'https://bitbucket.org/' . fake()->userName(),
            $eq('snapchat') || $has('snapchat') => 'https://snapchat.com/add/' . fake()->userName(),
            $eq('whatsapp') || $has('whatsapp') => 'https://wa.me/' . fake()->numerify('1##########'),
            $eq('telegram', 'tg') || $has('telegram') => 'https://t.me/' . fake()->userName(),
            $eq('discord') || $has('discord') => 'https://discord.gg/' . fake()->bothify('????####'),
            $eq('twitch') || $has('twitch') => 'https://twitch.tv/' . fake()->userName(),
            $eq('mastodon') => 'https://mastodon.social/@' . fake()->userName(),
            $eq('spotify') || $has('spotify') => 'https://open.spotify.com/user/' . fake()->userName(),
            $eq('soundcloud') || $has('soundcloud') => 'https://soundcloud.com/' . fake()->userName(),

            $eq('map', 'maps', 'google_map', 'google_maps', 'location_url') || $has('google_map', 'map_url', 'maps_url', 'map_link', 'maps_link') => 'https://www.google.com/maps?q=' . fake()->randomFloat(6, -90, 90) . ',' . fake()->randomFloat(6, -180, 180),

            $eq('url', 'website', 'link') || $ends('_url') => fake()->url(),
            $eq('domain') => fake()->domainName(),
            $eq('ip', 'ip_address') => fake()->ipv4(),
            $eq('mac', 'mac_address') => fake()->macAddress(),
            $eq('uuid') => fake()->uuid(),
            $eq('color', 'hex_color') || $ends('_color') => fake()->hexColor(),
            $eq('title', 'heading') || $ends('_title') => Str::title(fake()->words(asText: true)),
            $eq('subtitle', 'tagline') => fake()->sentence(6),
            $eq('description', 'summary', 'excerpt', 'caption') => fake()->sentence(12),
            $eq('bio', 'about') => fake()->paragraph(),
            $eq('price', 'amount', 'cost', 'total') => fake()->randomFloat(2, 5, 500),
            $eq('quantity', 'qty', 'stock') => fake()->numberBetween(1, 100),
            $eq('age') => fake()->numberBetween(18, 80),
            $eq('year') => fake()->year(),
            $eq('sku', 'code', 'reference') || $ends('_code') => strtoupper(fake()->bothify('??-####')),
            $eq('currency') => fake()->currencyCode(),
            $eq('locale', 'language') => fake()->locale(),
            $eq('timezone', 'tz') => fake()->timezone(),
            default => null,
        };

        return (string) ($by_name ?? match ($type) {
            'email' => fake()->safeEmail(),
            'number' => fake()->numberBetween(10, 20),
            'tel' => fake()->phoneNumber(),
            'url' => fake()->url(),
            'password' => fake()->password(),
            'color' => fake()->hexColor(),
            'date' => fake()->date(),
            'datetime-local' => fake()->dateTime()->format('Y-m-d\TH:i'),
            'time' => fake()->time('H:i'),
            'month' => fake()->date('Y-m'),
            'week' => fake()->date('Y-\WW'),
            'search' => fake()->word(),
            default => fake()->realTextBetween(40, 50),
        });
    }
}
