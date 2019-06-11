defmodule CheckerWeb.CheckController do
  use CheckerWeb, :controller

  def store(conn, _params) do
    Checker.Converter.convert(bulk())

    render(conn, "print.json", [])
  end

  defp bulk do
    %{
      "html" => "html 123",
      "settings" => [
        %{
          "key" => "key",
          "value" => "value"
        },
        %{
          "key" => "key",
          "value" => "value"
        }
      ],
      "plan" => %{
        "sizes" => %{
          "from" => 1000,
          "to" => 2000
        },
        "opening_block" => nil,
        "closing_block" => %{
          "heading" => "closing_block",
          "description" => "description",
          "sizes" => %{
            "from" => 1000,
            "to" => 2000
          },
          "keys" => [
            %{
              "value" => "value",
              "type" => "type",
              "count" => 100
            }
          ],
          "setting_blocks" => [
            %{
              "min" => 5,
              "max" => 10,
              "type" => "type"
            }
          ]
        },
        "blocks" => [
          %{
            "heading" => "heading",
            "description" => "description",
            "sizes" => %{
              "from" => 1000,
              "to" => 2000
            },
            "keys" => [
              %{
                "value" => "value",
                "type" => "type",
                "count" => 100
              }
            ],
            "setting_blocks" => [
              %{
                "min" => 5,
                "max" => 10,
                "type" => "type"
              }
            ]
          }
        ]
      }
    }
  end
end
