#!/bin/bash
set -e

mix deps.get

{
    mix start_mnesia
} || {
    echo "mix start_mnesia fails"
}

mix phx.server
