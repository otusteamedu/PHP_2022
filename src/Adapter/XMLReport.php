<?php

namespace Patterns\Adapter;

class XMLReport
{
    public function buildXML(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
            <data>
            <row>
              <event_id>1</event_id>
              <sport_kind>volleyball</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Bruno Reilly</full_name>
              <short_name>Blossom Ayers</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>null</level>
              <format>null</format>
              <type>null</type>
              <organization_id>3</organization_id>
              <club_id>1</club_id>
              <league_id>1</league_id>
              <season_id>1</season_id>
              <start_dt>2021-12-29</start_dt>
              <end_dt>2021-12-31</end_dt>
              <app_strict>0</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1640332081</created_at>
              <updated_at>1640332081</updated_at>
            </row>
            <row>
              <event_id>2</event_id>
              <sport_kind>football</sport_kind>
              <sport_type>personal</sport_type>
              <full_name>Keegan Sanchez</full_name>
              <short_name>Nina Newman</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>null</level>
              <format>null</format>
              <type>null</type>
              <organization_id>1</organization_id>
              <club_id>1</club_id>
              <league_id>1</league_id>
              <season_id>1</season_id>
              <start_dt>2021-12-30</start_dt>
              <end_dt>2022-01-01</end_dt>
              <app_strict>0</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1640361691</created_at>
              <updated_at>1640361691</updated_at>
            </row>
            <row>
              <event_id>3</event_id>
              <sport_kind>football</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Laurel Griffith</full_name>
              <short_name>Nehru Durham</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>null</level>
              <format>null</format>
              <type>null</type>
              <organization_id>3</organization_id>
              <club_id>1</club_id>
              <league_id>1</league_id>
              <season_id>1</season_id>
              <start_dt>2022-01-06</start_dt>
              <end_dt>2022-01-07</end_dt>
              <app_strict>1</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1640697607</created_at>
              <updated_at>1640697607</updated_at>
            </row>
            <row>
              <event_id>4</event_id>
              <sport_kind>basketball</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Kalia Howell</full_name>
              <short_name>Zeph Zamora</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>null</level>
              <format>null</format>
              <type>null</type>
              <organization_id>3</organization_id>
              <club_id>1</club_id>
              <league_id>3</league_id>
              <season_id>1</season_id>
              <start_dt>2022-01-07</start_dt>
              <end_dt>2022-01-09</end_dt>
              <app_strict>1</app_strict>
              <is_open>0</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1640697757</created_at>
              <updated_at>1640697757</updated_at>
            </row>
            <row>
              <event_id>5</event_id>
              <sport_kind>football</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Мероприятие с параметрами</full_name>
              <short_name>Мероприятие с параметрами</short_name>
              <description></description>
              <logo>null</logo>
              <gender>man</gender>
              <level>district</level>
              <format>mix</format>
              <type>image</type>
              <organization_id>null</organization_id>
              <club_id>null</club_id>
              <league_id>null</league_id>
              <season_id>2</season_id>
              <start_dt>2022-05-02</start_dt>
              <end_dt>2022-04-07</end_dt>
              <app_strict>0</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1648043502</created_at>
              <updated_at>1648715880</updated_at>
            </row>
            <row>
              <event_id>6</event_id>
              <sport_kind>volleyball</sport_kind>
              <sport_type>personal</sport_type>
              <full_name>Инд мероприятие</full_name>
              <short_name>Инд мероприятие</short_name>
              <description></description>
              <logo>null</logo>
              <gender>man</gender>
              <level>russia</level>
              <format>fulltime</format>
              <type>null</type>
              <organization_id>null</organization_id>
              <club_id>null</club_id>
              <league_id>null</league_id>
              <season_id>2</season_id>
              <start_dt>2022-03-21</start_dt>
              <end_dt>2022-04-10</end_dt>
              <app_strict>0</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1648622299</created_at>
              <updated_at>1648622299</updated_at>
            </row>
            <row>
              <event_id>7</event_id>
              <sport_kind>null</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Новое мероприятие</full_name>
              <short_name>Новое мероприятие</short_name>
              <description><p>Debitis officia mole.</p></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>russia</level>
              <format>fulltime</format>
              <type>education</type>
              <organization_id>null</organization_id>
              <club_id>null</club_id>
              <league_id>1</league_id>
              <season_id>2</season_id>
              <start_dt>2022-04-04</start_dt>
              <end_dt>2022-04-10</end_dt>
              <app_strict>1</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1648721781</created_at>
              <updated_at>1648721781</updated_at>
            </row>
            <row>
              <event_id>8</event_id>
              <sport_kind>null</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Еще одно мероприятие</full_name>
              <short_name>Еще одно мероприятие</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>regional</level>
              <format>fulltime</format>
              <type>education</type>
              <organization_id>null</organization_id>
              <club_id>null</club_id>
              <league_id>null</league_id>
              <season_id>2</season_id>
              <start_dt>2022-04-06</start_dt>
              <end_dt>2022-04-09</end_dt>
              <app_strict>1</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1648722290</created_at>
              <updated_at>1648722290</updated_at>
            </row>
            <row>
              <event_id>9</event_id>
              <sport_kind>борьба</sport_kind>
              <sport_type>team</sport_type>
              <full_name>Frances Gordon</full_name>
              <short_name>Reed Barron</short_name>
              <description></description>
              <logo>null</logo>
              <gender>null</gender>
              <level>regional</level>
              <format>remote</format>
              <type>corporate</type>
              <organization_id>3</organization_id>
              <club_id>2</club_id>
              <league_id>2</league_id>
              <season_id>2</season_id>
              <start_dt>2022-04-10</start_dt>
              <end_dt>2022-04-11</end_dt>
              <app_strict>0</app_strict>
              <is_open>1</is_open>
              <created_by>1</created_by>
              <updated_by>1</updated_by>
              <created_at>1648723812</created_at>
              <updated_at>1648723812</updated_at>
            </row>
            </data>
            ';
    }
}
